<?php
include("config/database.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contract_id = $_POST['contract_id'];
    $meter_serial = $_POST['meter_serial'];
    $meter_number = $_POST['meter_number'];

    $meter_type = $_POST['meter_type'] ?? 'SMART';
    $installation_date = $_POST['installation_date'];
    $status = $_POST['status'] ?? 'ACTIVE';
    $last_read_kwh = !empty($_POST['last_read_kwh']) ? $_POST['last_read_kwh'] : null;
    $last_read_time = !empty($_POST['last_read_time']) ? $_POST['last_read_time'] : null;

    $stmt = $db->prepare("INSERT INTO meters (contract_id, meter_serial,meter_number, meter_type, installation_date, status, last_read_kwh, last_read_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssds", $contract_id, $meter_serial,$meter_number, $meter_type, $installation_date, $status, $last_read_kwh, $last_read_time);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Meter added successfully.</div>";
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
                        Meter
                    </div>
                    <h2 class="page-title">
                        Add
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


        <div class="container-xl">
            <form method="POST" class="card">
                <div class="card-header"><h3 class="card-title">Add Meter</h3></div>
                <div class="card-body">
                    <div class="row row-cols-md-2 g-3">

                        <!-- Contract ID -->
                        <div class="col">
                            <label class="form-label">Contract</label>
                            <select name="contract_id" class="form-select" required>
                                <option value="">Select Contract</option>
                                <?php
                                $result = $db->query("SELECT id, contract_number FROM contracts ORDER BY id DESC");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['contract_number']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Meter Serial -->
                        <div class="col">
                            <label class="form-label">Meter Serial</label>
                            <input type="text" name="meter_serial" class="form-control" required>
                        </div>
                        <!-- Meter number -->
                        <div class="col">
                            <label class="form-label">Meter Number</label>
                            <input type="text" name="meter_number" class="form-control" required>
                        </div>

                        <!-- Meter Type from ref_meter_types -->
                        <div class="col">
                            <label class="form-label">Meter Type</label>
                            <select name="meter_type" class="form-select">
                                <?php
                                $types = $db->query("SELECT code, label FROM ref_meter_types ORDER BY label ASC");
                                while ($row = $types->fetch_assoc()) {
                                    echo "<option value='{$row['code']}'>{$row['label']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Installation Date -->
                        <div class="col">
                            <label class="form-label">Installation Date</label>
                            <input type="date" name="installation_date" class="form-control" required>
                        </div>

                        <!-- Status -->
                        <div class="col">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="RETIRED">RETIRED</option>
                                <option value="FAULTY">FAULTY</option>
                            </select>
                        </div>

                        <!-- Last Read kWh -->
                        <div class="col">
                            <label class="form-label">Last Read (kWh)</label>
                            <input type="number" name="last_read_kwh" step="0.001" class="form-control">
                        </div>

                        <!-- Last Read Time -->
                        <div class="col">
                            <label class="form-label">Last Read Time</label>
                            <input type="datetime-local" name="last_read_time" class="form-control">
                        </div>

                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Save Meter</button>
                </div>
            </form>
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