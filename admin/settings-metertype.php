<?php

include("config/database.php");
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
mysqli_query($db, "SET time_zone = 'Europe/Berlin';");

// Insert logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code']);
    $label = trim($_POST['label']);

    $stmt = mysqli_prepare($db, "INSERT INTO ref_meter_types (code, label) VALUES (?, ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $code, $label);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Fetch data for the table
$result = mysqli_query($db, "SELECT * FROM ref_meter_types");
?>



    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Meter types
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

        <div class="container-xl">
            <div class="row row-cols-md-2">

                <!-- Left column: Form -->
                <div class="col">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Add Meter Type</h3></div>
                        <div class="card-body">
                            <form method="POST" autocomplete="off">
                                <div class="mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" name="code" class="form-control" required maxlength="32">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Label</label>
                                    <input type="text" name="label" class="form-control" required maxlength="64">
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary w-100">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right column: Table -->
                <div class="col">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Existing Meter Types</h3></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Label</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['code']) ?></td>
                                            <td><?= htmlspecialchars($row['label']) ?></td>
                                            <td><a href="#">Disable</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- row -->
        </div> <!-- container -->



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