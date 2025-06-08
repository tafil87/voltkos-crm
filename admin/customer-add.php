<?php
include("config/database.php");
include("functions/customer_func.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $db->prepare("INSERT INTO customers (
        customer_code, name, billing_type, status, vat_number, phone, email, 
        address_line1, address_line2, city, zip_code, country
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ssssssssssss",
        $_POST['customer_code'],
        $_POST['name'],
        $_POST['billing_type'],
        $_POST['status'],
        $_POST['vat_number'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['address_line1'],
        $_POST['address_line2'],
        $_POST['city'],
        $_POST['zip_code'],
        $_POST['country']
    );

    if ($stmt->execute()) {


        echo '<div class="alert alert-success m-3">User successfully added!</div>';
    } else {

        echo '<div class="alert alert-error m-3">'.$stmt->error.'</div>';
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


                            <div class="card-header">
                                <h3 class="card-title">Add New Customer</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Customer Code</label>
                                            <input type="text" class="form-control" name="customer_code" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Billing Type</label>
                                            <select class="form-select" name="billing_type" required>
                                                <option value="PREPAID">PREPAID</option>
                                                <option value="POSTPAID">POSTPAID</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                <option value="ACTIVE" selected>ACTIVE</option>
                                                <option value="INACTIVE">INACTIVE</option>
                                                <option value="SUSPENDED">SUSPENDED</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Unique identification number (NUI)</label>
                                            <input type="text" class="form-control" name="vat_number">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone">
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address Line 1</label>
                                            <input type="text" class="form-control" name="address_line1">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address Line 2</label>
                                            <input type="text" class="form-control" name="address_line2">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ZIP Code</label>
                                            <input type="text" class="form-control" name="zip_code">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Country</label>
                                            <input type="text" class="form-control" name="country">
                                        </div>
<!--                                        <div class="mb-3">-->
<!--                                            --><?php
//
//                                            $nextId = getNextCustomerId($db);
//                                            if ($nextId !== null) {
//                                                $nextId = $nextId;
//                                            } else {
//                                                $nextId = "Failed to retrieve next ID.";
//                                            }
//                                            ?>
<!--                                            <label class="form-label">Contract ID</label>-->
<!--                                            <input type="text" class="form-control"  value="--><?php //echo $nextId ?><!--" disabled>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
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