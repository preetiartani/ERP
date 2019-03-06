<?php
require_once("constants.php");

$connection = mysqli_connect(SERVER, USER, PASSWORD, DB);

if(!$connection){
    echo "connection error :". mysqli_error($connection);
}

?>