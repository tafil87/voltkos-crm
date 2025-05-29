<?php
//include("functions/addGroups.php");
//
//if ($_SERVER["REQUEST_METHOD"] == "POST" and !isset($_POST['updated' ])) {
//    $groupname = $_POST['groupname'] ?? '';
//    $gender = $_POST['gender'] ?? '';
//    $status = $_POST['status'] ?? '';
//    $response = insertGroupData($db, $groupname, $gender, $status);
//}
//
//if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["Editid"])) {
//    $groupId = $_GET["Editid"] ?? '';
//    $GetData = getGroupDetailsById($db, $groupId);
//    $editFlagField = '<input type="hidden" id="updated" name="updated" value="'.$groupId.'">';
//}
//
//if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['updated' ])) {
//
//    $groupname = $_POST['groupname'] ?? '';
//    $gender = $_POST['gender'] ?? '';
//    $status = $_POST['status'] ?? '';
//    $updated_id = $_POST['updated'] ?? '';
//    $response = updateGroupData($db, $updated_id, $groupname, $gender, $status);
//}


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

                            <div class="card-body">
                                <h3 class="card-title">Add User</h3>
                                <div class="row row-cards">

                                    <?php echo $editFlagField;?>
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-0">
                                            <label class="form-label"> Name</label>
                                            <textarea rows="5" class="form-control" name="groupname" placeholder="Here can be your description" value="Mike"><?php if(isset($GetData[0]['name'])){echo $GetData[0]['name']; }else{ ?>Your group here<?php }?></textarea>
                                        </div>
                                    </div>




                                    <div class="col-md-6">
                                        <div class="form-label">Gender</div>
                                        <select name="gender" class="form-select">
                                            <option value="0"<?php if($GetData[0]['gender'] === 0){echo ' selected ';}?>>Both</option>
                                            <option value="1"<?php if($GetData[0]['gender'] === 1){echo ' selected ';}?>>Male</option>
                                            <option value="2"<?php if($GetData[0]['gender'] === 2){echo ' selected ';}?>>Female</option>
                                        </select>


                                        <div class="col-md-6">
                                            <div class="form-label">Status</div>
                                            <select name="status"  class="form-select">
                                                <option value="1" <?php if($GetData[0]['status'] === 1){echo ' selected ';}?>>Active</option>
                                                <option value="0" <?php if($GetData[0]['status'] === 0){echo ' selected ';}?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <?php  if(isset($response['message'])){echo '<span class="badge badge-outline text-azure">'.$response['message'].'</span>';} ?>

                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Add User</button>
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