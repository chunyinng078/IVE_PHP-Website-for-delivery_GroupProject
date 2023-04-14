<?php
session_start();
//$_SESSION['staffID'] = 'Mary112';
$staffID =$_SESSION['staffID'];
$_SESSION['sit'];
//var_dump($_SESSION);
?>
<?php
$timeout = 360;


if( isset( $_SESSION[ 'lastAct' ] ) ) {

    // get time different since last action
    $duration = time() - intval( $_SESSION[ 'lastAct' ] );

    // if time out
    if( $duration > $timeout ) {

        // Clear the session
        session_unset();

        // Destroy the session
        session_destroy();

        //redirect to timeout page
        header("Location: timeOut.php");
    }

}
//if not login or login as customer
if (!isset($_SESSION['staffID']))
    header("Location: NoPermisson.php");
//get last action time if login ed and not time out
$_SESSION[ 'lastAct' ]= time();
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="image/logoWhite.png">
  <link rel="stylesheet" href="css/index.css">

  <style >
    tr{
      text-align: center;
    }
    /*set url font color*/
    a {
        text-decoration:none;
        color: white;
    }
  </style>
  <title>Main Page</title>
</head>

<body  background="image/background.png"> <!-- background -->
<!--  <link rel="stylesheet" href="index.css">-->
  <!-- nav bar     a ul contain li, and those li may contain  ul and li -->
<div class="navbar" id="staffNavbar">
    <ul>
        <li><a href='staffWebPage.php' >
                <div class="logo"> <img src="image/logo.png" alt="lol-logo">   <!-- icon -->
                </div>
            </a>
        </li>
        <li>
            <a href='UpdateAirwayBill.php'>🔧 Update Air Waybill</a>
        </li>

        <li>
            <a href='CreateDeliveryRecord.php'>✏️ Create delivery record</a>
        </li>

        <li>
            <a href='GenerateReport.php'>📈 Generate report</a>
        </li>

        <li>
            <a href='DeleteDeliveryRequest.php'>🗳️ Delete delivery request</a>
        </li>

        <li>
            <a href='logout.php'>📲 Logout Account</a>
        </li>
    </ul>
</div>

  <!--paragraph-->
<div class="main-content">
    <h1>Update Airway Bill</h1>
    <?php
    include "conn.php";
    $conn = getDBconnection();
    $sql = "SELECT `airWaybillNo`, `staffID`, `weight`, `totalPrice` FROM `airwaybill`";
    $rs = mysqli_query($conn, $sql) or
    die(mysqli_error($conn));
    $num = mysqli_num_rows($rs);
    if($num!=0){
        echo<<<title
        <table border="1">
          <tr>
            <th>Airway Bill No</th>
            <th>Staff ID</th>
            <th>Weight</th>
            <th>Total Price</th>
          </tr>
title;
        while ($outPut = mysqli_fetch_array($rs)){
            echo<<<table
        <tr height="50dp">
            <td><a href="UpdateAirwayBill.php?airWaybillNo=$outPut[0]" </a>$outPut[0]</td>
            <td>$outPut[1]</td>
            <td>$outPut[2]</td>
            <td>$outPut[3]</td>
        </tr>
table;
    }
//  when staff select the record, display the records Airway bill no and weight
    echo"</table>";
    }else
        echo "There was no any data in database!<br>";
//<!-- desplay the Airway bill detail-->
    if (!empty($_GET)){
        $airWaybillNo ="";
        extract($_GET);
        //select the value of table airwaybill and customer
        $sql = "SELECT airWaybillNo,weight,locationID,a.customerEmail,accountCreationDate FROM airwaybill a ,customer c  where airWaybillNo ='$airWaybillNo'";
        $rs = mysqli_query($conn, $sql) or
        die(mysqli_error($conn));
        $outPut0 = mysqli_fetch_array($rs);
        $sql = "SELECT accountCreationDate FROM customer where customerEmail ='$outPut0[customerEmail]'";
        $rs = mysqli_query($conn, $sql) or
        die(mysqli_error($conn));
        $outPut = mysqli_fetch_array($rs);
        //var_dump($outPut);
        include 'claculator.php';
        $rate = calculate($outPut['accountCreationDate']);
        //var_dump($outPut);
        echo<<<form
    <form action='AirwayBill2.php' method="get" name="update" >
        <div>The Airway Bill No: <input type="text" readonly value="$outPut0[airWaybillNo]" name="airWaybillNo"></div>
        <div>The Weight Of Package: <input type="text" value="$outPut0[weight]" name="weight"></div>
        <div>
            <input type="submit" style="height:40dp;width:30dp"  value="Submit"/>
            <input type="text" name="staffID" value="$staffID" hidden/>
            <input type="text" name="locationID" value="$outPut0[locationID]" hidden/>
            <input type="text" name="rate" value="$rate" hidden/>
        </div>
    </form>
    <br><br><br>
  </div>
form;


    }
    mysqli_free_result($rs);
    mysqli_close($conn);
    ?>



</body>

</html>