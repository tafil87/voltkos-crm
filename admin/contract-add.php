<?php
include("config/database.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $contract_number = $_POST['contract_number'];
    $tariff_code = $_POST['tariff_code'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'] ?: null;
    $status = $_POST['status'] ?? 'PENDING';
    $billing_cycle = $_POST['billing_cycle'] ?? 'MONTHLY';

    // Handle file upload
    $upload_dir = "uploads/";
    $filename_upload = null;

    if (isset($_FILES['contract_file']) && $_FILES['contract_file']['error'] === UPLOAD_ERR_OK) {
        $original_name = basename($_FILES['contract_file']['name']);
        $ext = pathinfo($original_name, PATHINFO_EXTENSION);
        $safe_name = uniqid('contract_', true) . '.' . $ext;
        $target_path = $upload_dir . $safe_name;

        if (move_uploaded_file($_FILES['contract_file']['tmp_name'], $target_path)) {
            $filename_upload = $safe_name;
        } else {
            echo "<div class='alert alert-danger'>File upload failed.</div>";
        }
    }

    $stmt = $db->prepare("INSERT INTO contracts (customer_id, contract_number, tariff_code, start_date, end_date, status, billing_cycle, filename_upload) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $customer_id, $contract_number, $tariff_code, $start_date, $end_date, $status, $billing_cycle, $filename_upload);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Contract inserted successfully.</div>";
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
                        Contract
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

        <div class="col-lg-12">
            <div class="row row-cards">
                <div class="col-12">
                    <form class="card" enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?navId='.$navId;?>">
                        
                            <div class="page-body">
                                <div class="container-xl">
                                    <div class="card">
                                        <div class="card-header"><h3 class="card-title">Add Contract</h3></div>
                                        <div class="card-body">
                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <label class="form-label">Customer</label>
                                                    <select name="customer_id" class="form-select" required>
                                                        <option value="">Select Customer</option>
                                                        <?php
                                                        $result = mysqli_query($db, "SELECT id, name FROM customers ORDER BY name");
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Contract Number</label>
                                                    <input type="text" name="contract_number" class="form-control" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Tariff Code</label>
                                                    <select name="tariff_code" class="form-select" required>
                                                        <option value="">Select Tariff</option>
                                                        <?php
                                                        $result = mysqli_query($db, "SELECT tariff_code, name FROM tariffs ORDER BY name");
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option value='{$row['tariff_code']}'>{$row['tariff_code']} - {$row['name']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">End Date</label>
                                                    <input type="date" name="end_date" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="PENDING">Pending</option>
                                                        <option value="ACTIVE">Active</option>
                                                        <option value="EXPIRED">Expired</option>
                                                        <option value="TERMINATED">Terminated</option>
                                                    </select>
                                                </div>


                                                <div class="col-md-6">
                                                    <label class="form-label">Upload Contract Document</label>
                                                    <input type="file" name="contract_file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                                                </div>


                                                <div class="col-md-6">
                                                    <label class="form-label">Billing Cycle</label>
                                                    <select name="billing_cycle" class="form-select">
                                                        <option value="MONTHLY">Monthly</option>
                                                        <option value="QUARTERLY">Quarterly</option>
                                                        <option value="ANNUAL">Annual</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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