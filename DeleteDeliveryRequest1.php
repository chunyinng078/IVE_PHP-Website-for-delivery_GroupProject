<?php
session_start();
//var_dump($_SESSION);
$_SESSION['sit']=1;
?>
<?php
extract($_GET);
include "conn.php";
$conn = getDBconnection();
$sql = "DELETE FROM `airwaybilldeliveryrecord` WHERE `airWaybillNo` = '$airWaybillNo'";
$rs = mysqli_query($conn, $sql) or
die(mysqli_error($conn));
$sql = "DELETE FROM `airwaybill` WHERE `airWaybillNo` = '$airWaybillNo'";
$rs = mysqli_query($conn, $sql) or
die(mysqli_error($conn));
$msg  = "<script>alert('delete success!');</script>";
var_dump($msg);
//display message
header("Location: DeleteDeliveryRequest.php?msg=$msg");
?>