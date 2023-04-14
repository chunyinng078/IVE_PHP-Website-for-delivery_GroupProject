<?php
var_dump($_GET);
extract($_GET);
include "conn.php";
//set constraint
if($airWaybillNo!=''&&$status!=''&&$location!=''&&$recordDateTime!=''){
    $conn = getDBconnection();
    $sql = "SELECT * FROM `airwaybilldeliveryrecord` WHERE `airWaybillNo` = '$airWaybillNo'";
    $rs = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($rs);
    if($count>0){
        $sql = "INSERT INTO `airwaybilldeliveryrecord`(`airWaybillNo`, `deliveryStatusID`, `recordDateTime`, `currentLocation`) VALUES ('$airWaybillNo','$status','$recordDateTime','$location')";
        $rs = mysqli_query($conn, $sql) or
        die(mysqli_error($conn));
        $msg  = "<script>alert('create success!');</script>";
    }else
        $msg  = "<script>alert('please insert a valid airwayBill ID!');</script>";


}else{
    $msg  = "<script>alert('please insert all column');</script>";
}
//return to crate delivery page
header("Location: CreateDeliveryRecord.php?msg=$msg");
?>
