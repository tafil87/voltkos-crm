<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'dompdf/autoload.inc.php';
include("config/database.php");
include("config/general.php");

use Dompdf\Dompdf;

$invoiceId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $db->prepare("SELECT * FROM `invoices` i JOIN `customers` c ON i.customer_id = c.id JOIN `contracts` co ON i.contract_id = co.id WHERE i.id = ?");
$stmt->bind_param("i", $invoiceId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invoice not found.");
}

$invoice = $result->fetch_assoc();
$stmt->close();

$reference = 'INV-' . str_pad($invoice['id'], 6, '0', STR_PAD_LEFT);
$barcodeUrl = 'https://barcode.tec-it.com/barcode.ashx?data=' . urlencode($reference) . '&code=Code128';

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
    .header { display: flex; align-items: center; border-bottom: 2px solid #198754; margin-bottom: 20px; padding-bottom: 10px; }
    .logo { width: 70px; }
    .company-name { font-size: 22px; font-weight: bold; color: #198754; margin-left: 15px; }
    .section-title { font-weight: bold; margin-top: 20px; color: #198754; }
    .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .table, .table td, .table th { border: 1px solid #d0d0d0; }
    .table th { background-color: #e6f4ea; color: #198754; }
    .table th, .table td { padding: 6px; text-align: left; }
    .total-row { font-weight: bold; background-color: #f3f3f3; }
    .barcode { margin-top: 20px; text-align: right; }
</style>
</head>
<body>

<div class="header">
    <img src="'.$app_url.'admin/static/voltkos.jpeg" class="logo" />
    <div class="company-name">VoltKos</div>
</div>

<p><span class="section-title">Informata të përgjithshme të furnizuesit / General Supplier Information</span><br>
<strong>Fatura nr. / Invoice #:</strong> '.$reference.'<br>
<strong>Nr. Unik i Biznesit / UIN:</strong> 812270817<br>
<strong>Nr. TVSH / VAT Number:</strong> 330647539<br>
<strong>Adresa e furnizuesit / Supplier Address:</strong> Perandori Dioklecian 17, 10000 Prishtinë, Republika e Kosovës</p>

<p class="section-title">Të dhënat e konsumatorit / Customer Information</p>
<p>
<strong>ID Konsumatorit / Customer ID:</strong> '.$invoice['customer_code'].'<br>
<strong>Emri / Name:</strong> '.htmlspecialchars($invoice['name']).'<br>
<strong>Biznesi / Business:</strong> '.htmlspecialchars($invoice['business_name'] ?? 'N/A').'<br>
<strong>NUI i Biznesit / Business NUI:</strong> '.htmlspecialchars($invoice['nui'] ?? 'N/A').'<br>
<strong>Adresa / Address:</strong> '.htmlspecialchars($invoice['address_line1']).'
</p>

<p class="section-title">Detaje të matjes / Metering Details</p>
<p>
<strong>Muaji / Month:</strong> '.htmlspecialchars($invoice['period-start']).'<br>
<strong>Stina / Season:</strong> Verë / Summer<br>
<strong>ID e rrugës / Route ID:</strong> '.htmlspecialchars($invoice['route_id'] ?? '___').'<br>
<strong>Kodi i linjës / Feeder Code:</strong> '.htmlspecialchars($invoice['feeder_code'] ?? '___').'<br>
<strong>Nr. i matësit / Meter No.:</strong> '.htmlspecialchars($invoice['meter_number'] ?? '___').' – '.htmlspecialchars($invoice['meter_type'] ?? 'AMR').'<br>
<strong>Grupi i tarifës / Tariff Group:</strong> '.htmlspecialchars($invoice['tariff_group'] ?? '0.4v').'<br>
<strong>Konstanta / Constant:</strong> '.htmlspecialchars($invoice['constant'] ?? '1.0').'<br>
<strong>Data e leximit / Reading Date:</strong> '.htmlspecialchars($invoice['reading_date'] ?? '___').'
</p>

<p class="section-title">Leximet mujore në kWh / Meter Readings (in kWh)</p>
<table class="table">
<tr><th>Zonë / Zone</th><th>Aktuale / Current</th><th>Paraprake / Previous</th><th>Diferenca / Difference</th></tr>
<tr><td>A1</td><td>'.$invoice['reading_a1'].'</td><td>1920.33</td><td>'.($invoice['reading_a1'] - 1920.33).'</td></tr>
<tr><td>A2</td><td>'.$invoice['reading_a2'].'</td><td>1133.07</td><td>'.($invoice['reading_a2'] - 1133.07).'</td></tr>
<tr><td>R1</td><td>'.$invoice['reading_r1'].'</td><td>164.61</td><td>'.($invoice['reading_r1'] - 164.61).'</td></tr>
<tr><td>R2</td><td>'.$invoice['reading_r2'].'</td><td>83.37</td><td>'.($invoice['reading_r2'] - 83.37).'</td></tr>
</table>

<p class="section-title">Konsumi dhe çmimi / Monthly Consumption and Prices</p>
<table class="table">
<tr><th>Zonë / Zone</th><th>Konsumi / Consumption</th><th>Çmimi €/kWh / Price</th><th>Shuma / Amount (€)</th></tr>
<tr><td>A1</td><td>'.$diffA1.'</td><td>'.$invoice['price_a1'].'</td><td>'.number_format($amtA1, 2).'</td></tr>
<tr><td>A2</td><td>'.$diffA2.'</td><td>'.$invoice['price_a2'].'</td><td>'.number_format($amtA2, 2).'</td></tr>
<tr><td>R1</td><td>'.$diffR1.'</td><td>'.$invoice['price_r1'].'</td><td>'.number_format($amtR1, 2).'</td></tr>
<tr><td>R2</td><td>'.$diffR2.'</td><td>'.$invoice['price_r2'].'</td><td>'.number_format($amtR2, 2).'</td></tr>
</table>

<p class="section-title">Tarifat / Charges by Activity</p>
<table class="table">
<tr><td>Furnizim / Supply</td><td>'.number_format($invoice['supply_cost'], 2).' €</td></tr>
<tr><td>OSSH / DSO</td><td>'.number_format($invoice['dso_cost'], 2).' €</td></tr>
<tr><td>OST / TSO</td><td>'.number_format($invoice['tso_cost'], 2).' €</td></tr>
<tr><td>BRE / RES</td><td>'.number_format($invoice['res_cost'], 2).' €</td></tr>
<tr><td>Tarifë fikse / Fixed Fee</td><td>'.number_format($invoice['fixed_fee'], 2).' €</td></tr>
</table>

<p class="section-title">Përmbledhje / Totals</p>
<table class="table">
<tr><td>Totali neto / Net Total</td><td>'.number_format($invoice['total'] - $invoice['vat'], 2).' €</td></tr>
<tr><td>TVSH (8%) / VAT</td><td>'.number_format($invoice['vat'], 2).' €</td></tr>
<tr><td><strong>Totali / Total Invoice</strong></td><td><strong>'.number_format($invoice['total'], 2).' €</strong></td></tr>
<tr><td><strong>Borxhi i papaguar / Outstanding Debt</strong></td><td><strong>'.number_format($invoice['debt'] ?? 0, 2).' €</strong></td></tr>
</table>

<div class="barcode">
    <img src="'.$barcodeUrl.'" alt="Barcode" />
</div>

</body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("invoice-{$invoiceId}.pdf", ["Attachment" => false]);
