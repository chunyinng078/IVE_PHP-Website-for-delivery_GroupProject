<?php
$hostname = "127.0.0.1";
$username = "root";
$pwd = "";
$db = "projectdb";

function getDBconnection(){
    global $hostname,$username,$pwd,$db;
    $conn = mysqli_connect($hostname,$username,$pwd,$db)
    or die(mysqli_error());
    return $conn;
}

?>
