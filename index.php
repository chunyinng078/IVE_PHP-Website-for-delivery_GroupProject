<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="image/logoWhite.png">

  <title>Login</title>



</head>

<body background="image/background.png">

<link rel="stylesheet" href="css/login.css">
  <!--paragraph-->

  <div style="text-align:center">

    <form class="login" action="index.php" method="post">
      <img src="image/logo.png">
      <h1>EDE Delivery System</h1>
      <div class="txt_field">
        <input type="text" name="account" required placeholder="Account"/>
        <span></span>

      </div>

      <div class="txt_field">
        <input type="password" name="password" required placeholder="Password"/>
        <span></span>
      </div>
      <br>
        <div id="errorMsg" class="errorMsg"></div>
        <br>
      <input type="submit" name="login" value="Login" >


      <!--<a href="staffWebPage.html"/><input type="button" value="Staff Login"/>-->

    </form>


  </div>

  <br>



</body>

</html>
<?php


//if form submited
if (isset($_POST['login'])){


    //connect db
    include "conn.php";
    $conn = getDBconnection();

    //get customer input (ac and pw)
    $username = mysqli_real_escape_string($conn,$_POST['account']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    //search if customer exist
    $sql = "SELECT * FROM customer WHERE customerEmail = '$username'";
    $rs = mysqli_query($conn,$sql);
    $customerFound = mysqli_num_rows($rs);

    //search if staff exist
    $sql = "SELECT * FROM staff WHERE staffID = '$username'";
    $rs2 = mysqli_query($conn,$sql);
    $staffFound = mysqli_num_rows($rs2);




    //search if customer exist and with right pw
    $sql = "SELECT * FROM customer WHERE customerEmail = '$username' and customerPassword = '$password'";
    $rs = mysqli_query($conn,$sql);
    $customerPass = mysqli_num_rows($rs);

    //search if staff exist and with right pw
    $sql = "SELECT * FROM staff WHERE staffID = '$username' and staffPassword = '$password'";
    $rs2 = mysqli_query($conn,$sql);
    $staffPass = mysqli_num_rows($rs2);
    mysqli_close($conn);

    // if account not exist

    if ($customerPass==1) {
        session_start();
        session_destroy();

        //get custid
        while ($rc = mysqli_fetch_assoc($rs)) {
            $cusID = $rc['customerEmail'];
        }

        //create session for customer
        session_start();
        $_SESSION['cusID'] = $cusID;
        $_SESSION['lastAct'] = time();

        //go to customer main page
        header("Location: customerWebPage.php");
    }else if($staffPass==1){     //search if staff exist and pw match
        session_start();
        session_destroy();

        //get staff id
        while ($rc = mysqli_fetch_assoc($rs2)) {
            $staffID= $rc['staffID'];
        }

        //create session for staff
        session_start();
        $_SESSION['staffID'] = $staffID;
        $_SESSION['lastAct'] = time();

        //go to staff main page
        header("Location: staffWebPage.php");
    } else if ($staffFound==0&&$customerFound==0){  //if account not found in db
        ?>
        <script type="text/javascript">
            const errorMsg = document.getElementById('errorMsg');
            errorMsg.style.background = 'yellow';
            document.getElementById("errorMsg").innerHTML="Account not exist!";
        </script>
        <?php
    }
    else{
        //tell user wrong password
        ?>
        <script type="text/javascript">
            const errorMsg = document.getElementById('errorMsg');
            errorMsg.style.background = 'yellow';
            document.getElementById("errorMsg").innerHTML="Wrong password!";
        </script>
        <?php



    }


    if (isset($rs))
        mysqli_free_result($rs);

    if (isset($rs2))
        mysqli_free_result($rs2);

}
?>