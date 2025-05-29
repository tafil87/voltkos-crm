<?php
define('DB_SERVER', 'db1b.crm.voltkos.com');
define('DB_USERNAME', 'voltkoscrm');
define('DB_PASSWORD', 'siht2!3Sx3feS5Essb45?');
define('DB_DATABASE', 'voltkoscrm');
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
mysqli_query($db, "SET time_zone = 'Europe/Berlin';");