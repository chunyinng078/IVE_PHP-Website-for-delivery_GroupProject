<?php
session_start();

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
$staffID=$_SESSION['staffID'];
$_SESSION['sit'] = 0;
?>
<!DOCTYPE html>
<html>

<head>

  <link rel="icon" href="image/logoWhite.png">
  <link rel="stylesheet" href="css/index.css">


  <title>Main Page</title>

</head>

<body  background="image/background.png"> <!-- background -->
<!--  <link rel="stylesheet" href="index.css">-->
  <!-- nav bar     a ul contain li, and those li may contain  ul and li -->
<div class="navbar" id="staffNavbar">
    <ul>
        <li><a href="staffWebPage.php" >
                <div class="logo"> <img src="image/logo.png" alt="lol-logo">   <!-- icon -->
                </div>
            </a>
        </li>
        <li>
            <a href="UpdateAirwayBill.php">🔧 Update Air Waybill</a>
        </li>

        <li>
            <a href="GenerateReport.php">✏️ Create delivery record</a>
        </li>

        <li>
            <a href="GenerateReport.php">📈 Generate report</a>
        </li>

        <li>
            <a href="DeleteDeliveryRequest.php">🗳️ Delete delivery request</a>
        </li>

        <li>
            <a href="logout.php">📲 Logout Account</a>
        </li>
    </ul>
</div>
<?php
include "conn.php";
$conn = getDBconnection();//connect method
$sql = "SELECT `staffName` FROM `staff` WHERE `staffID`='$staffID'";//query
$rs = mysqli_query($conn, $sql) or//action
die(mysqli_error($conn));
$output=mysqli_fetch_array($rs);//output
echo <<<info
  <!--paragraph-->
  <div class="main-content">   <!--write  things here-->
    <br><br><br>
    <h1>Eastern Delivery Express (EDE) Limited</h1>
      <br>
      <h2>Welcome back, $output[0]!<br>What can we help you today?</h2><br>
      <img src="image/welcome.jpeg">
    <br><br><br>
  </div>
info;
?>
  <br>
</body>

</html>