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
  
  <style>
    tr{
      text-align: center;
    }
  </style>
  <title>Main Page</title>

</head>

<body  background="image/background.png"> <!-- background -->
<!--  <link rel="stylesheet" href="index.php">-->
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
            <a href="CreateDeliveryRecord.php">✏️ Create delivery record</a>
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

  <!--paragraph-->
  <div class="main-content">   
    <h1>Generate report</h1>
      <?php
      include "conn.php";
      //set default value
      $count = 0;
      $maxTotal =0.0;
      $minTotal =0.0;
      $conn = getDBconnection();
      $sql = "SELECT COUNT(*) AS count, MAX(totalPrice) AS maxTotal, MIN(totalPrice) AS minTotal FROM airwaybill";
      $rs = mysqli_query($conn, $sql) or
      die(mysqli_error($conn));
      $num = mysqli_num_rows($rs);
      //insert value
      while ($outPut = mysqli_fetch_array($rs)){
          $count = $outPut[0];
          $maxTotal = $outPut[1];
          $minTotal = $outPut[2];
          //var_dump($outPut);
      }
      if($maxTotal==""){
          $maxTotal=0;
          $minTotal=0;
      }

      $sql = "SELECT totalPrice FROM `airwaybill`";
      $rs = mysqli_query($conn, $sql) or
      die(mysqli_error($conn));
      $total = 0.0;
      //calculate total value
      while ($outPut = mysqli_fetch_array($rs)){
          $total+=$outPut[0];
      }
      echo<<<information
<!--    display information-->
    Number of Airway Bill: $count <br>
    Total income: $total<br>
    Maximum price for each shipment: $maxTotal<br>
    Minimum price for each shipment: $minTotal<br>
    <br>
information;
      //var_dump($num);
      if($count!=0){
      echo <<<form
<!--    use datalist and radio to do the order by function-->
<form method="get" action="GenerateReport.php">
      Order By:
      <input type="radio" value="asc" name="tableOrder"/>Ascending
      <input type="radio" value="desc" name="tableOrder" checked="checked" />Descending
      
      <select name="column" id="column" style="background-color: gray; color: white; font-size: bold">
         <option value="a.airWaybillNo">Air Waybill’s Number</option>
         <option value="c.customerEmail">Customer’s Email</option>
         <option value="c.customerName">Customer’s Name</option>
         <option value="staffID">Staff’s ID</option>
         <option selected value="date">Date</option>
         <option value="receiverName">Receiver Name</option>
         <option value="receiverPhoneNumber">Receiver Phone Number</option>
         <option value="receiverAddress">Receiver Address</option>
         <option value="weight">Weight</option>
         <option value="totalPrice">Total Price</option>
      </select>
        <input type="submit" value="Enter" style="width: 10%;">
    </form>
    <br>
    <br>
form;

      echo<<<title
<!--    display report-->
<div style="overflow-x: auto;">
<table border="1" >
 <tr>
 <th>Air Waybill’s Number</th>
 <th>Customer’s Email</th>
 <th>Customer’s Name</th>
 <th>Staff’s ID</th>
 <th>Date</th>
 <th>Receiver Name</th>
 <th>Receiver Phone Number</th>
 <th>Receiver Address</th>
 <th>Weight</th>
 <th>Total Price</th>
</tr>
title;
      if(!empty($_GET)){
          extract($_GET);
          $sql = "SELECT a.airWaybillNo,c.customerEmail,c.customerName ,staffID, date, receiverName, receiverPhoneNumber, receiverAddress, weight, totalPrice FROM airwaybill a, customer c WHERE c.customerEmail = a.customerEmail order by $column $tableOrder";
      }
      else
          $sql = "SELECT a.airWaybillNo, a.customerEmail,c.customerName ,staffID, date, receiverName, receiverPhoneNumber, receiverAddress, weight, totalPrice FROM airwaybill a, customer c WHERE c.customerEmail = a.customerEmail";
      $rs = mysqli_query($conn, $sql) or
      die(mysqli_error($conn));
      while ($outPut = mysqli_fetch_array($rs)){
          echo<<<table
<!--    insert to each columns-->
    <tr>
        <td>$outPut[0]</td>
        <td>$outPut[1]</td>
        <td>$outPut[2]</td>
        <td>$outPut[3]</td>
        <td>$outPut[4]</td>
        <td>$outPut[5]</td>
        <td>$outPut[6]</td>
        <td>$outPut[7]</td>
        <td>$outPut[8]</td>
        <td>$outPut[9]</td>
    </tr>
table;
      }
      echo"</table>";
      }else
          echo "There was no any data in database!<br>";
      //var_dump($rs);
      mysqli_free_result($rs);
      mysqli_close($conn);
      ?>
  </div>
    <br><br><br>
  </div>

  <br>

</body>

</html>