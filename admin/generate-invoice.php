<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'dompdf/autoload.inc.php';
include("config/database.php");
include("config/general.php");
use Dompdf\Dompdf;

// Get the invoice ID
$invoiceId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $db->prepare("SELECT * FROM `invoices` i JOIN `customers` c ON i.customer_id = c.id JOIN `contracts` co ON i.contract_id = co.id WHERE  i.id = ?");
$stmt->bind_param("i", $invoiceId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invoice not found.");
}

$invoice = $result->fetch_assoc();
$stmt->close();
$reference = 'INV-' . str_pad($invoice['id'], 6, '0', STR_PAD_LEFT);
$barcodeUrl = 'https://barcode.tec-it.com/barcode.ashx?data=' . urlencode($reference) . '&code=Code128&translate-esc=false';

// Calculate differences and amounts
function calcAmount($prev, $curr, $price) {
    $diff = $curr - $prev;
    return [$diff, $diff * $price];
}

list($diffA1, $amtA1) = calcAmount(1920.33, $invoice['reading_a1'], $invoice['price_a1']);
list($diffA2, $amtA2) = calcAmount(1133.07, $invoice['reading_a2'], $invoice['price_a2']);
list($diffR1, $amtR1) = calcAmount(164.61, $invoice['reading_r1'], $invoice['price_r1']);
list($diffR2, $amtR2) = calcAmount(83.37, $invoice['reading_r2'], $invoice['price_r2']);


$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; }
        .header { display: flex; align-items: center; border-bottom: 2px solid #198754; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 70px; }
        .company-name { font-size: 22px; font-weight: bold; color: #198754; margin-left: 15px; }
        .section-title { font-weight: bold; margin-top: 20px; color: #198754; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table, .table td, .table th { border: 1px solid #d0d0d0; }
        .table th { background-color: #e6f4ea; color: #198754; }
        .table th, .table td { padding: 6px; text-align: left; }
        .total-row { font-weight: bold; background-color: #f3f3f3; }
        .red { color: red; }
    </style>
</head>
<body>

<div class="header">
    <img src="'.$app_url.'admin/static/voltkos.jpeg" class="logo" />
    <div class="company-name">VoltKos</div>
</div>

<p><span class="section-title">Invoice Details</span><br>
<strong>Customer:</strong> '.htmlspecialchars($invoice['name']).'<br>
<strong>Address:</strong> '.htmlspecialchars($invoice['address_line1']).'<br>
<strong>Period:</strong> '.htmlspecialchars($invoice['period-start']).'</p>

<p class="section-title">Energy Consumption</p>
<table class="table">
    <tr>
        <th>Tariff</th>
        <th>Current</th>
        <th>Previous</th>
        <th>Difference</th>
        <th>Unit Price (€)</th>
        <th>Amount (€)</th>
    </tr>
    <tr>
        <td>A1</td><td>'.$invoice['reading_a1'].'</td><td>1920.33</td><td>'.number_format($diffA1, 2).'</td><td>'.$invoice['price_a1'].'</td><td>'.number_format($amtA1, 2).'</td>
    </tr>
    <tr>
        <td>A2</td><td>'.$invoice['reading_a2'].'</td><td>1133.07</td><td>'.number_format($diffA2, 2).'</td><td>'.$invoice['price_a2'].'</td><td>'.number_format($amtA2, 2).'</td>
    </tr>
    <tr>
        <td>R1</td><td>'.$invoice['reading_r1'].'</td><td>164.61</td><td>'.number_format($diffR1, 2).'</td><td>'.$invoice['price_r1'].'</td><td>'.number_format($amtR1, 2).'</td>
    </tr>
    <tr>
        <td>R2</td><td>'.$invoice['reading_r2'].'</td><td>83.37</td><td>'.number_format($diffR2, 2).'</td><td>'.$invoice['price_r2'].'</td><td>'.number_format($amtR2, 2).'</td>
    </tr>
</table>

<p class="section-title">Billing Summary</p>
<table class="table">
    <tr><td>Electricity Supply</td><td>'.number_format($invoice['supply_cost'], 2).' €</td></tr>
    <tr><td>OSSH / DSO</td><td>'.number_format($invoice['dso_cost'], 2).' €</td></tr>
    <tr><td>OST / TSO</td><td>'.number_format($invoice['tso_cost'], 2).' €</td></tr>
    <tr><td>BRE / RES</td><td>'.number_format($invoice['res_cost'], 2).' €</td></tr>
    <tr><td>Fixed Charge</td><td>'.number_format($invoice['fixed_fee'], 2).' €</td></tr>
    <tr class="total-row"><td>Net Total</td><td>'.number_format($invoice['total'] - $invoice['vat'], 2).' €</td></tr>
    <tr class="total-row"><td>VAT</td><td>'.number_format($invoice['vat'], 2).' €</td></tr>
    <tr class="total-row"><td>Total Bill</td><td class="red">'.number_format($invoice['total'], 2).' €</td></tr>
</table>

</body>
</html>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("invoice-{$invoiceId}.pdf", ["Attachment" => false]);
