<?php
include("config/database.php");
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
mysqli_query($db, "SET time_zone = 'Europe/Berlin';");

// Fetch customers
$customers = [];
$result = mysqli_query($db, "SELECT id, name FROM customers");
while ($row = mysqli_fetch_assoc($result)) {
    $customers[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    insertUser($_POST, $db);
}

function insertUser($data, $db) {
    $stmt = mysqli_prepare($db, "
        INSERT INTO users (username, name, surename, email, password, status, expiration, customer_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

//    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    $hashedPassword=$data['password'];
    $customerId = !empty($data['customer_id']) ? $data['customer_id'] : null;

    mysqli_stmt_bind_param($stmt, "sssssis" . ($customerId !== null ? "i" : "s"),
        $data['username'],
        $data['name'],
        $data['surename'],
        $data['email'],
        $hashedPassword,
        $data['status'],
        $data['expiration'],
        $customerId
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo '<div class="alert alert-success m-3">User successfully added!</div>';
}
?>


    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Users
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

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Add New User</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Surename</label>
                                            <input type="text" class="form-control" name="surename" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status" required>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Expiration Date</label>
                                            <input type="date" class="form-control" name="expiration" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer</label>
                                            <select class="form-select" name="customer_id">
                                                <option value="">-- Select Customer --</option>
                                                <?php foreach ($customers as $customer): ?>
                                                    <option value="<?= htmlspecialchars($customer['id']) ?>">
                                                        <?= htmlspecialchars($customer['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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