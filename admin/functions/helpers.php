<?php



//displays errors
function debug($level)
{


if($level === true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

}

function printarray($array)
{

    echo '<pre>';
    print_r($array);
    echo '</pre>';

}