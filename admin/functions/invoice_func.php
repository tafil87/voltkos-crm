<?php
function generateInvoiceForContract($customerId, $billingMonth, $db)
{
    // Escape values
    $customerIdEscaped = mysqli_real_escape_string($db, $customerId);
    $billingMonthEscaped = mysqli_real_escape_string($db, $billingMonth);

    // Check if invoice already exists
    $checkSql = "
        SELECT id FROM invoices
        WHERE contract_id = '$customerIdEscaped'
        AND DATE_FORMAT(invoice_date, '%Y-%m') = '$billingMonthEscaped'
        LIMIT 1
    ";
    $checkResult = mysqli_query($db, $checkSql);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "❗ Invoice already exists for contract ID $customerId and month $billingMonth\n";
        return;
    }

    // Get contract, customer, meter info
    $contractSql = "
        SELECT
            c.id AS contract_id,
            cu.id AS customer_id,
            cu.name AS customer_name,
            m.id AS meter_id,
            m.meter_serial
        FROM contracts c
        JOIN customers cu ON c.customer_id = cu.id
        JOIN meters m ON m.contract_id = c.id
        WHERE cu.id = '$customerIdEscaped'
    ";
    $contractResult = mysqli_query($db, $contractSql);
    if (!$contractResult || mysqli_num_rows($contractResult) === 0) {
        echo "❗ Contract or meter info not found.\n";
        return;
    }
    $info = mysqli_fetch_assoc($contractResult);

    // Pull meter readings
    $readingsSql = "
        SELECT zone, current_reading, previous_reading
        FROM meter_readings
        WHERE meter_id = '{$info['meter_id']}'
        AND DATE_FORMAT(reading_date, '%Y-%m') = '$billingMonthEscaped'
    ";
    $readingsResult = mysqli_query($db, $readingsSql);
    $readings = [];
    while ($row = mysqli_fetch_assoc($readingsResult)) {
        $readings[] = $row;
    }

    // Calculate consumption
    $zones = ['A1', 'A2', 'R1', 'R2'];
    $consumption = [];
    $totalKWh = 0;
    $pricePerKwh = 0.07;

    foreach ($zones as $zone) {
        $diff = 0;
        foreach ($readings as $r) {
            if ($r['zone'] === $zone) {
                $diff = $r['current_reading'] - $r['previous_reading'];
                break;
            }
        }
        $consumption[$zone] = $diff;
        $totalKWh += $diff;
    }

    // Pricing
    $energyCost = $totalKWh * $pricePerKwh;
    $fixedFee = 2.00;
    $dso = 0.01 * $energyCost;
    $tso = 0.005 * $energyCost;
    $res = 0.003 * $energyCost;

    $net = $energyCost + $dso + $tso + $res + $fixedFee;
    $vat = $net * 0.08;
    $total = $net + $vat;

    // Insert invoice
    $insertSql = "
        INSERT INTO invoices
        (contract_id, customer_id, invoice_date, kwh_total, net_amount, vat_amount, total_amount)
        VALUES (
            '{$info['contract_id']}',
            '{$info['customer_id']}',
            '{$billingMonth}-01',
            '$totalKWh',
            '$net',
            '$vat',
            '$total'
        )
    ";
    $insertResult = mysqli_query($db, $insertSql);

    if ($insertResult) {
        echo "✔️ Invoice generated for contract $customerId ($billingMonth)\n";
    } else {
        echo "❗ Error inserting invoice: " . mysqli_error($db) . "\n";
    }
}
