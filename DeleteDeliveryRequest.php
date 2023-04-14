<?php
session_start();
//var_dump($_SESSION);
$sit = $_SESSION['sit'];
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
    <script type="text/javascript">
        //change situation
        function change(){
            <?php
            $_SESSION['sit']=0;
            ?>
        }
    </script>
    <style>
        a {
            text-decoration:none;
            color: white;
        }
    </style>
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
    <h1>Delete delivery request</h1>
      <?php
      include "conn.php";
      $conn = getDBconnection();
      $sql = "SELECT a.airWaybillNo, c.customerEmail,c.customerName, date FROM airwaybill a, customer c WHERE c.customerEmail = a.customerEmail";
      $rs = mysqli_query($conn, $sql) or
      die(mysqli_error($conn));
      $num = mysqli_num_rows($rs);
if($num!=0){
    echo<<<title
<table border="1">
      <tr>
        <th>Airway Bill No</th>
        <th>Customer Email</th>
        <th>customer Name</th>
        <th>Date</th>
      </tr>
title;
    while ($outPut = mysqli_fetch_array($rs)){
        echo<<<table
    <tr height="50dp">
        <td><a href="DeleteDeliveryRequest.php?airWaybillNo=$outPut[0]" onclick="change()"</a>$outPut[0]</td>
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

if (!empty($_GET)&&$sit==0){
      //$_SESSION['sit']=1;
      //var_dump($_SESSION);
      $airWaybillNo ="";
      extract($_GET);
      $sql = "SELECT `airWaybillNo` FROM `airwaybill` where airWaybillNo ='$airWaybillNo'";
      $rs = mysqli_query($conn, $sql) or
      die(mysqli_error($conn));
      $outPut = mysqli_fetch_array($rs);
      $counter= mysqli_num_rows($rs);
      if($counter>0){
          echo<<<form
        <form action="DeleteDeliveryRequest1.php" method="get" name="update" >
            <div>The Selected Airway Bill No is $outPut[0]</div>
            <div>Are You sure do delete this record?</div>
            <div>
                <input type="submit" style="height:40dp;width:30dp"  value="Delete"/>
                <input type="text" name="airWaybillNo" value="$airWaybillNo" hidden/>
            </div>
        </form>    
<br><br><br>
</div>
form;
  }

}
      mysqli_free_result($rs);
      mysqli_close($conn);
      ?>
<?php
    if((!empty($_GET))&&($sit==1)){
//        display the message
        $msg="";
        extract($_GET);
        //var_dump($_GET);
        if($msg!=""){
            echo "$msg";
        }
    }


?>

  <br>

</body>

</html>