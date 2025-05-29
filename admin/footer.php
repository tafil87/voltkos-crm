<?php


include("config/general.php");


?>

<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">

                </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        Copyright &copy;  <?php echo $app_copyright_date ?>
                        <a href="." class="link-secondary"><?php echo $app_name ?></a>.
                        All rights reserved.
                    </li>
                    <li class="list-inline-item">
                        <a  class="link-secondary" rel="noopener">
                            <?php echo $app_version ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
