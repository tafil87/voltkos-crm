<?php
include("functions/user_func.php");
$users = getUsers($db);
?>

    <!-- jQuery FIRST -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
                        Show
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

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Registered Users</h3>
                        </div>
                        <div class="card-body">


                            <div id="table-default" class="table-responsive">



                                <table id="users-table" class="table card-table table-vcenter datatable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Created&nbsp;at</th>
                                        <th>Expires</th>
                                        <th>Customer&nbsp;ID</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($users as $u): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($u['id']) ?></td>
                                            <td><?= htmlspecialchars($u['username']) ?></td>
                                            <td><?= htmlspecialchars($u['name']) ?></td>
                                            <td><?= htmlspecialchars($u['surename']) ?></td>
                                            <td><?= htmlspecialchars($u['email']) ?></td>
                                            <td><?= $u['status'] ? 'Active' : 'Inactive' ?></td>
                                            <td><?= htmlspecialchars($u['created_date']) ?></td>
                                            <td><?= htmlspecialchars($u['expiration']) ?></td>
                                            <td><?= htmlspecialchars($u['customer_id']) ?></td>
                                            <td><a href="#">Edit</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>


                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <!--                            <button type="submit" class="btn btn-primary">Make request</button>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>


    <link href="dist/js/datatables/datatables.css?11=asa" rel="stylesheet">


    <script src="dist/js/datatables/datatables.min.js"></script>
    <!-- INITIALISE DATATABLE -->
    <script>

        document.addEventListener("DOMContentLoaded", () => {
            $('#users-table').DataTable({
                dom: 'Bfrtip',               // Buttons, filter, table, pagination
                buttons: [
                    { extend: 'copy',   className: 'btn btn-0' },
                    { extend: 'csv',    className: 'btn btn-0' },
                    { extend: 'excel',  className: 'btn btn-0' },
                    { extend: 'pdf',    className: 'btn btn-0' },
                    { extend: 'print',  className: 'btn btn-0' }
                ],
                order: [[0,'desc']],
                pageLength: 25,
                lengthMenu: [10,25,50,100],
                responsive: true,

                /* ▸ hide the default “Search:” label and set placeholder */
                language: {search:'', searchPlaceholder:'Search…'},

                /* ▸ run once the table is ready: add Tabler classes & icon */
                initComplete: function () {
                    const $input = $('div.dataTables_filter input');     // grab the box
                    $input.addClass('form-control form-control-sm ps-7'); // Tabler sizing

                    // wrap it with the Tabler “input-icon” pattern
                    $input.wrap('<div class="input-icon"></div>')
                        .before('<span class="input-icon-addon"><i class="ti ti-search"></i></span>');
                }
            });
        });
    </script>
    <script src="./dist/libs/list.js/dist/list.min.js?16sadasd7" defer></script>


<?php include('footer.php');?>