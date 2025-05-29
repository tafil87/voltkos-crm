<?php
session_start();
$_SESSION = [];
session_destroy();
?>

<head>
    <meta http-equiv="refresh" content="3;url=login.php">
</head>



<div class="page page-center">
    <div class="container container-slim py-4">
        <div class="text-center">
            <div class="mb-3">
                <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo-small.svg" height="36" alt=""></a>
            </div>
            <div class="text-secondary mb-3">Log out of application</div>
            <div class="progress progress-sm">
                <div class="progress-bar progress-bar-indeterminate"></div>
            </div>
        </div>
    </div>
</div>

