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

$cusID = $_SESSION['cusID'];
include "conn.php";
$conn = getDBconnection();


?>
<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="image/logoWhite.png">
  <link rel="stylesheet" href="css/index.css">
  <title>Update Profile</title>

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
      <div class="msg" id="msg"></div>
      <h1>Update Profile</h1>
      <form method="POST"  class="updateProfile">
        <h3>Your Information</h3>
        <cdlabel>What is your new account name?</cdlabel><br>
          <?php

            //get all current customer profile
             $sql = "SELECT * FROM customer WHERE customerEmail = '$cusID'";
             $rs = mysqli_query($conn,$sql);

             //store customer profile to var and use it in below
              while ($rc = mysqli_fetch_assoc($rs)) {
                  $original_customerName = $rc['customerName'];
                  $original_customerPassword = $rc['customerPassword'];
                  $original_phoneNumber = $rc['phoneNumber'];
                  $original_address = $rc['address'];
             }
             echo "<input type='text'  required placeholder='Name' name='name' id='name' value='$original_customerName' ><br><br>";
          ?>

        <cdlabel>What is your new account password?</cdlabel><br>
          <?php
            echo "<input type='password'  required placeholder='Password' name='password' id='password' value='$original_customerPassword'><br><br>";
          ?>
        <cdlabel>What is  your new phone no.?</cdlabel><br>
          <?php
            echo " <input type='tel' required placeholder='Phone' name='phone' id='phone' pattern='[0-9]{8}' minlength='8' maxlength='8' value='$original_phoneNumber'><br><cdlabel>(e.g. 12345678)</cdlabel><br><br>";
          ?>
        <cdlabel>What is your new address?</cdlabel><br>
          <?php
            //echo "<input type='text' required placeholder='Address' name='address' id='address' value='$original_address'><br><br>";
            //echo "";
          ?>
          <textarea id='address' name='address' rows='4' cols='50' ><?php echo $original_address ?></textarea>
        <h3>Verify</h3>
        <cdlabel>Please enter your current password.</cdlabel><br><input type="password"  required placeholder="Password" name="verify"><br><br>


        <input type="submit" value="Submit" name="submit" id="submit" onsubmit="return checkform()">
        </form>
    <br><br><br>
  </div>

  <br>


</body>

</html>
<?php

//if form submited

if (isset($_POST['submit'])){

    //get all updated profile
    $newName=$_POST['name'];
    $newPW=$_POST['password'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $address = trim(preg_replace('/\s\s+/', ' ', $address));


    //check verify password is right or not
    $cusID=$_SESSION['cusID'];
    $sql = "SELECT customerPassword FROM customer WHERE customerEmail = '$cusID'";
    $rs = mysqli_query($conn,$sql);

    while ($rc = mysqli_fetch_assoc($rs)) {
        $currentPW = $rc['customerPassword'];
    }

    $success = mysqli_affected_rows($conn);

    //if verify password is not right, show wrong password message
    if ($currentPW!=$_POST['verify']){
        echo "    
    <script type='text/javascript'>
        const msg = document.getElementById('msg');
        msg.style.color = 'red';
        msg.style.background = 'yellow';
        document.getElementById('msg').innerHTML='Wrong password! \\n Please enter your password again to verify yourself!';
        
    </script>";
    }else if ($currentPW==$_POST['verify']) { //if verify password is  right, update db

        //set sql and update db
        $sql = "UPDATE `customer` SET `customerName`='$newName',`customerPassword`='$newPW',`phoneNumber`='$phone',`address`='$address' WHERE customerEmail='$cusID'";
        $rs = mysqli_query($conn,$sql);

        //show all the newest profile data and tell customer update success
    echo "        
        <script type='text/javascript'>
            document.getElementById('name').value='$newName';
            document.getElementById('password').value='$newPW';
            document.getElementById('phone').value='$phone';
            document.getElementById('address').value='$address';

            alert('Update Profile Successful !');
        </script>";



    }
}

?>

<?php

if (isset($conn))
    mysqli_close($conn);



?>
