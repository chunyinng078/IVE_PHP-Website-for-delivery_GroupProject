<?php
var_dump($_GET);
extract($_GET);
$weight = (double)$weight;
//set the weight value
if(fmod($weight,1) != 0){
    $weight1=(int)$weight+1;
    echo "cannot";
}else{
    $weight1=(int)$weight;
    echo "can";
}

$locationID = (int)$locationID;
$rate = (double)$rate;
//set constraint
if (($locationID == 3 && $weight1<=5)||($locationID == 1 && $weight1<=10)||($locationID == 2 && $weight1<=10))
{
    include "conn.php";
    $conn = getDBconnection();
    $sql = "SELECT `rate` FROM `chargetable` WHERE `locationID`='$locationID' AND `weight`='$weight1'";
    $rs = mysqli_query($conn, $sql) or
    die(mysqli_error($conn));
    $outPut = mysqli_fetch_array($rs);
    $total = $outPut[0]*(1-$rate);
    $sql = "UPDATE `airwaybill` SET `staffID`='$staffID',`weight`='$weight',`totalPrice`='$total' WHERE `airWaybillNo` = '$airWaybillNo'";
    $rs = mysqli_query($conn, $sql) or
    die(mysqli_error($conn));
    $msg = "<script>alert('Update success!');</script>";
}else
    $msg = "<script>alert('Please insert correct data!');</script>";
//display message and return to airway bill page
header("Location: UpdateAirwayBill.php");

?>

