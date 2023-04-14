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
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="image/logoWhite.png">
  <link rel="stylesheet" href="css/index.css">
  <title>Main Page</title>
<script>
</script>
</head>

<body  background="image/background.png"> <!-- background -->
<!--  <link rel="stylesheet" href="index.php">-->
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
  <div class="main-content">   <!--write  things here-->
   <form method="get" action="deliveryRecord.php">
    <h1>Create Delivery Record</h1>
    Air Waybill’s Number: <input type="text" name="airWaybillNo"/><br>
    <p class="radioTitle">Shipment status: </p>
<!--       //set radio button-->
    <div class="radioGp">
     <label> <input type="radio" name="status" value="1"/> Waiting for Confirmation </label> 
      <label> <input type="radio" name="status" value="2"/> Confirmed </label> 
      <label>  <input type="radio" name="status" value="3"/> In Transit </label> 
      <label> <input type="radio" name="status" value="4"/> Delivering  </label> 
      <label> <input type="radio" name="status" value="5"/> Completed</label> 
    </div>
    <br>
    Record Date &amp; Time:<input type="datetime-local" name="recordDateTime"/><br>
    Current location:
<!--    set the data list-->
   <input list="location" name="location">
    <datalist id="location">
      <option value="Japan">
      <option value="Australia">
      <option value="Shanghai">
      <option value="Hong Kong">
  </datalist><br>
    <input type="submit" value="Submit" id="btnSubmit"/>
    <input type="reset" value="Reset" id="btnReset"/>
  </form>
    <br><br><br>
  </div>

  <br>
//display message
<?php
if(!empty($_GET)){
    extract($_GET);
    if($msg!=""){
        echo "$msg";
    }
}
?>

</body>

</html>