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
  <title>Welcome to EDE</title>

</head>

<body  background="image/background.png"> <!-- background -->

  <!-- nav bar     a ul contain li, and those li may contain  ul and li -->
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
    <br><br><br>
      <h1>Eastern Delivery Express (EDE) Limited</h1>
      <br>
      <h2>Welcome back,


          <?php

            include "conn.php";
            $conn = getDBconnection();


                //get and show customer name

                $cusID=$_SESSION['cusID'];

                $sql = "SELECT customerName FROM customer WHERE customerEmail = '$cusID'";
                $rs = mysqli_query($conn,$sql);

                while ($rc = mysqli_fetch_assoc($rs)) {
                    $cusName = $rc['customerName'];
                }

                echo $cusName." !";

          ?>



          <br>What can we help you today?</h2>
      <br>
      <h2>We promise to provide the best delivery service.</h2>
      <img src="image/deliveryMan.png">
    <br><br><br>
  </div>

  <br>


</body>

</html>

<?php

if (isset($conn))
    mysqli_close($conn);

if (isset($rs))
    mysqli_free_result($rs);

if (isset($rs2))
    mysqli_free_result($rs2);

?>