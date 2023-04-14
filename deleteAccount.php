<?php
session_start();

//set max connection time
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


    }

}
    //if not login or login as customer
    if (!isset($_SESSION['cusID']))
        header("Location: NoPermisson.php");

//get last action time if login ed and not time out
$_SESSION[ 'lastAct' ]= time();
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="image/logoWhite.png">
  <link rel="stylesheet" href="css/index.css">
  <title>Delete Account</title>

</head>

<body  background="image/background.png"> <!-- background -->
  <link rel="stylesheet" href="index.css">
  <div class="navbar">
    <ul>
      <li><a href="customerWebPage.php">
          <div class="logo"> <img src="image/logo.png" alt="lol-logo">   <!-- icon -->
          </div>
        </a>
      </li>

      
      <li><a>✈️Shipment</a>
        <div class="sub-meun">
          <ul>
            <li><a href="createDelivery.php">Create delivery request</a> </li>
            <li><a href="trackDelivery.php">Track delivery status</a></li>
          </ul>
        </div>
      </li>
      <li><a>🙍‍♂️Account</a>
        <div class="sub-meun">
          <ul>
            <li><a href="updateProfile.php">Update profile</a> </li>
            <li><a href="deleteAccount.php">Delete Account</a></li>
          </ul>
        </div>
      </li>


      </li>

      <li><a>📁Resources</a>
        <div class="sub-meun">
          <ul>
            <li><a href="https://www.google.com.hk/maps" target="_blank">Google Maps</a></li>
            <li><a href="https://www.customs.gov.hk/tc/home/index.html" target="_blank">Hong Kong Customs</a></li>
          </ul>
        </div>

      </li>

      <li><a href="aboutUs.php">📪About Us</a></li>
      <li><a href="logout.php">📲Logout</a></li>
    </ul>
  </div>
  </div>


  <!--paragraph-->
  <div class="main-content">   <!--write  things here-->
    <br>
      <h1>Delete Account</h1>
      <form method="POST"  class="deleteAccount">
        <div class="notice">
          <h2>Important note before deactivating your EDE Delivery account</h2>
          <ul>
            <li>Your account will be deleted which is irreversible.</li>
            <li>All your related record in the database will be deleted.</li>
            <li>We assumes no responsibility of the consequences.</li>
          </ul>  
        </div>
        <br>
        <input type="checkbox" required>  I agree.
        <br><br>
        <h3>Verify</h3>
        <cdlabel>Please enter your current password.</cdlabel><br><input type="password"  required placeholder="Password" name="verify"><br><br>
        <input type="submit" value="Submit" name="submit">
          <br><br>
          <div  class="msg" id="msg">

          </div>
      </form>
    <br><br><br>
  </div>

  <br>

</body>

</html>

<?php

    //connect db
    include "conn.php";
    $conn = getDBconnection();

    //if form submited
    if (isset($_POST['submit'])){

        //check password is right or not
        $cusID=$_SESSION['cusID'];
        $sql = "SELECT customerPassword FROM customer WHERE customerEmail = '$cusID'";
        $rs = mysqli_query($conn,$sql);

        while ($rc = mysqli_fetch_assoc($rs)) {
            $currentPW = $rc['customerPassword'];
        }

        //if password not right
        if ($currentPW!=$_POST['verify']){
            echo "    <script type='text/javascript'>
        const msg = document.getElementById('msg');
        msg.style.color = 'red';
        msg.style.background = 'yellow';
        document.getElementById('msg').innerHTML='Wrong password! Please enter your password again to verify yourself!';
        
    </script>";
            //password  right
        }elseif ($currentPW==$_POST['verify']){

            //delete record in aiwaybilldeliveryrecord
            $sql="DELETE FROM airwaybilldeliveryrecord
                  WHERE EXISTS
                  (SELECT *
                  FROM airwaybill
                  WHERE airwaybill.airWaybillNo = airwaybilldeliveryrecord.airWaybillNo
                  AND airwaybill.customerEmail = '$cusID');";
            $rs = mysqli_query($conn,$sql);

            //delete record in airwaybill
            $sql="DELETE FROM `airwaybill` WHERE customerEmail = '$cusID'";
            $rs = mysqli_query($conn,$sql);

            //delete record in customer
            $sql="DELETE FROM `customer` WHERE customerEmail='$cusID'";
            $rs = mysqli_query($conn,$sql);

            //clear session and rediect to account deleted page
            session_destroy();
            header("Location: accountDeleted.php");
        }
    }




?>

<?php

if (isset($conn))
    mysqli_close($conn);

if (isset($rs))
    mysqli_free_result($rs);

if (isset($rs2))
    mysqli_free_result($rs2);

?>