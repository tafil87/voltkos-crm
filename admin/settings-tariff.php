<?php
include("config/database.php");

// Handle Form 1: Add New Tariff
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_tariff'])) {
    $tariff_code = $_POST['tariff_code'];
    $name = $_POST['name'];
    $currency = $_POST['currency'];
    $standing_charge = $_POST['standing_charge'];

    $stmt = $db->prepare("INSERT INTO tariffs (tariff_code, name, currency, standing_charge) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $tariff_code, $name, $currency, $standing_charge);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Tariff inserted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Handle Form 2: Add Tariff Rate
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rate'])) {
    $tariff_id = $_POST['tariff_id'];
    $valid_from = $_POST['valid_from'];
    $valid_to = $_POST['valid_to'];
    $rate_type = $_POST['rate_type'];
    $price_per_kwh = $_POST['price_per_kwh'];
    $vat_percent = $_POST['vat_percent'];

    $stmt = $db->prepare("INSERT INTO tariff_rates (tariff_id, valid_from, valid_to, rate_type, price_per_kwh, vat_percent) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssdd", $tariff_id, $valid_from, $valid_to, $rate_type, $price_per_kwh, $vat_percent);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Tariff rate inserted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>


    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Tariffs
                    </div>
                    <h2 class="page-title">
                        Manage
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">

                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">








        <div class="page-wrapper">
            <div class="container-xl mt-4">
                <div class="row row-cols-md-2 g-4">
                    <!-- Form 1: Add Tariff -->
                    <div class="col">
                        <form method="POST" class="card">
                            <div class="card-header"><h3 class="card-title">Add Tariff</h3></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Tariff Code</label>
                                    <input type="text" name="tariff_code" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Currency</label>
                                    <input type="text" name="currency" class="form-control" value="EUR" maxlength="3" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Standing Charge (€) (Fixed Monthly Charge)</label>
                                    <input type="number" step="0.0001" name="standing_charge" class="form-control" required>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" name="submit_tariff" class="btn btn-primary">Save Tariff</button>
                            </div>
                        </form>
                    </div>

                    <!-- Tariff Table -->
                    <div class="col">
                        <div class="card">
                            <div class="card-header"><h3 class="card-title">Existing Tariffs</h3></div>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Charge</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result = mysqli_query($db, "SELECT * FROM tariffs ORDER BY id DESC");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['tariff_code']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['standing_charge']}</td>
                      </tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form 2: Add Tariff Rate -->
                <div class="row mt-4">
                    <div class="col">
                        <form method="POST" class="card">
                            <div class="card-header"><h3 class="card-title">Add Tariff Rate</h3></div>
                            <div class="card-body row row-cols-md-3 g-3">
                                <div class="col">
                                    <label class="form-label">Tariff</label>
                                    <select name="tariff_id" class="form-select" required>
                                        <option value="">Select Tariff</option>
                                        <?php
                                        $tariffs = mysqli_query($db, "SELECT id, name FROM tariffs ORDER BY name");
                                        while ($tariff = mysqli_fetch_assoc($tariffs)) {
                                            echo "<option value='{$tariff['id']}'>{$tariff['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">Valid From</label>
                                    <input type="date" name="valid_from" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Valid To</label>
                                    <input type="date" name="valid_to" class="form-control" >
                                </div>
                                <div class="col">
                                    <label class="form-label">Rate Type</label>
                                    <select name="rate_type" class="form-select">
                                        <option value="A1/B1">A1/B1</option>
                                        <option value="A2/B1">A2/B1</option>
                                        <option value="A1/B2">A1/B2</option>
                                        <option value="A2/B2">A2/B2</option>
                                        <option value="R1">R1</option>
                                        <option value="R2">R2</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">Price per kWh (€)</label>
                                    <input type="number" step="0.0001" name="price_per_kwh" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">VAT %</label>
                                    <input type="number" step="0.01" name="vat_percent" class="form-control" value="0.00" required>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" name="submit_rate" class="btn btn-primary">Save Tariff Rate</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table: Existing Tariff Rates -->
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header"><h3 class="card-title">Existing Tariff Rates</h3></div>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tariff</th>
                                        <th>Rate Type</th>
                                        <th>Valid From</th>
                                        <th>Valid To</th>
                                        <th>€/kWh</th>
                                        <th>VAT %</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result = mysqli_query($db, "
                      SELECT r.*, t.name AS tariff_name 
                      FROM tariff_rates r
                      JOIN tariffs t ON r.tariff_id = t.id
                      ORDER BY r.id DESC
                    ");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['tariff_name']}</td>
                        <td>{$row['rate_type']}</td>
                        <td>{$row['valid_from']}</td>
                        <td>{$row['valid_to']}</td>
                        <td>{$row['price_per_kwh']}</td>
                        <td>{$row['vat_percent']}</td>
                      </tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>















    </div>


    <script src="./dist/libs/list.js/dist/list.min.js?1692870487" defer></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const list = new List('table-default', {
                sortClass: 'table-sort',
                listClass: 'table-tbody',
                valueNames: [ 'sort-name', 'sort-type', 'sort-city', 'sort-score',
                    { attr: 'data-date', name: 'sort-date' },
                    { attr: 'data-progress', name: 'sort-progress' },
                    'sort-quantity'
                ]
            });
        })
    </script>

<?php include('footer.php');?>