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
  <title>About Us</title>

</head>

<body  background="image/background.png"> <!-- background -->
  <link rel="stylesheet" href="index.css">
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
    <br>
      <h1>About Us</h1>
      <img src="image/logo.png" style="height: auto; width: 20%;"> 
      <p style="text-align: left; margin: 30px;" >
        &emsp;&emsp;&emsp;&emsp;The main business of the Eastern Delivery Express Limited (EDE) is to provide delivery services from Hong Kong to three countries that are Australia, Shanghai-China and Japan. The services include Express Document Envelope and Express Freight (package). The headquarters of the Company is situated in Hong Kong. The Company has two Operations Centres in Hong Kong and one Operation Centre in each of the countries.
        <h2>Contact</h2>
        Hotline: +852 9787 6450
        <br><br>
        Email: cs@ede.com
      </p>


        
      <div>



      </div>
    <br><br><br>
  </div>

  <br>

</body>

</html>


