<?php
include("config/database.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $contract_number = $_POST['contract_number'];
    $tariff_code = $_POST['tariff_code'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'] ?: null;
    $status = $_POST['status'] ?? 'PENDING';
    $billing_cycle = $_POST['billing_cycle'] ?? 'MONTHLY';

    $stmt = $db->prepare("INSERT INTO contracts (customer_id, contract_number, tariff_code, start_date, end_date, status, billing_cycle) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $customer_id, $contract_number, $tariff_code, $start_date, $end_date, $status, $billing_cycle);

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
                        Customer
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
                                                    <input type="text" name="tariff_code" class="form-control" required>
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