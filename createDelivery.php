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
  <title>Create Delivery</title>

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
      <h1>Create Delivery</h1>
      <form method="POST" action="" class="createDelivery">
        
        <!--
        <h3>Your Information</h3>
        <cdlabel>What is the Air Waybill’s No. ?</cdlabel><br><input type="number" required placeholder="Air Waybill’s No. "><br><br>
        -->
        <h3>Receiver’s Information</h3>
        <cdlabel>What is the reciver's name?</cdlabel><br><input type="text"  required placeholder="Name" name="name"><br><br>
        <cdlabel>What is the reciver's phone no.?</cdlabel><br><input type="tel" required placeholder="Phone" name="phone" pattern="[0-9]{8}" minlength="8" maxlength="8"><br><cdlabel>(e.g. 12345678)</cdlabel><br><br>
        <cdlabel>What is the reciver's address?</cdlabel><br>

          <textarea id='address' name='address' rows='4' cols='50'placeholder="Address" ></textarea><br><br>
        <cdlabel>What is the Location?</cdlabel><br>
        <select id="location" name="location" class="location">
          <option value=1>China Shanghai</option>
          <option value=2>Japan</option>
          <option value=3>Australia</option>
        </select>
        <br><br>
          <div class="msg" id="msg" ></div>
        <input type="submit" value="Submit" name="submit">  <input type="reset" value="Clear">
        </form>
    <br><br><br>
  </div>

  <br>

</body>

</html>

<?php
//clear all session file if exist

if (isset($_POST['submit'])){


    //connect db
    include "conn.php";
    $conn = getDBconnection();

    //set time zone to hong kong
    date_default_timezone_set("Asia/Hong_Kong");

    //get data from form
    $email=$_SESSION['cusID'];
    $locationID=$_POST['location'];
    $date=date('Y-m-d H:i:s');;
    $receiverName=$_POST['name'];
    $phone =$_POST['phone'];
    $address=$_POST['address'];

    $address = trim(preg_replace('/\s\s+/', ' ', $address));



    //insert airway bill
    $sql = "INSERT INTO `airwaybill`(`customerEmail`, `locationID`, `date`, `receiverName`, `receiverPhoneNumber`,`receiverAddress`) 
            VALUES ('$email','$locationID','$date','$receiverName','$phone','$address')";

    //run the sql
    $rs = mysqli_query($conn,$sql);

    //see if any action was made in db
    $success = mysqli_affected_rows($conn);


    //find max airwaybillno
    $sql = "SELECT MAX(airWaybillNo) FROM airwaybill";

    //run the sql
    $rs = mysqli_query($conn,$sql);

    //get max airwaybillno
    while ($rc = mysqli_fetch_assoc($rs)) {
        $lastestID = $rc['MAX(airWaybillNo)'];
    }

    //see if any action was made in db
    $success2 = mysqli_affected_rows($conn);


    //insert airwaybill record
    $sql = "INSERT INTO  `airwaybilldeliveryrecord`(`airWaybillNo`,`deliveryStatusID`,`recordDateTime`,`currentLocation`)
            value ('$lastestID',1,'$date',null)
";


    //run the sql
    $rs = mysqli_query($conn,$sql);

    //see if any action was made in db
    $success3 = mysqli_affected_rows($conn);



    //if success insert into two table
    if ($success==1&&$success3==1) {
        ?>

        <script type="text/javascript">

            alert("Create successful!");
        </script>
<?php
    }
    else{ //if not success
        //tell user wrong password
        ?>

        <script type="text/javascript">
            const msg = document.getElementById('msg');
            msg.style.color = 'red';
            msg.style.background = 'yellow';
            document.getElementById("msg").innerHTML="Error occurred";
        </script>
        <?php
    }
}
if (isset($conn))
    mysqli_close($conn);







?>