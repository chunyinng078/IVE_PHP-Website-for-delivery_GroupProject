<?php
//clear session data
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="image/logoWhite.png">
  <link rel="stylesheet" href="css/index.css">
  <title>You have been time out.</title>

</head>

<body  background="image/background.png"> <!-- background -->
  <link rel="stylesheet" href="index.css">
 


  <!--paragraph-->
  <div class="main-content">   <!--write  things here-->
    <br><br><br>
      <h1>You have been logout due to inactivate.</h1>
      Please login again.
      <br><br>
      <a href="index.php">Back to login</a>
    <br><br><br>
  </div>

  <br>

</body>

</html>