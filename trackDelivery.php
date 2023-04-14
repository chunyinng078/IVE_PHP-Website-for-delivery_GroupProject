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

//get cusid
$email = $_SESSION['cusID'] ;

$search=null;
$non_search=null;

//if form submit ed
if (isset($_POST['submit'])){
    //get connection to db and show the details record customer wanted
    include "conn.php";
    $conn = getDBconnection();

    $cusID=$_SESSION['cusID'];
    $airWaybillSearch=$_POST['filterID'];
    $sql="SELECT airwaybilldeliveryrecord.airWaybillNo,airwaybilldeliveryrecord.recordDateTime,customer.customerName ,airwaybill.receiverName,airwaybill.receiverPhoneNumber,airwaybill.weight, airwaybilldeliveryrecord.deliveryStatusID,airwaybilldeliveryrecord.currentLocation FROM airwaybilldeliveryrecord,airwaybill,customer WHERE airwaybill.airWaybillNo = airwaybilldeliveryrecord.airWaybillNo AND airwaybill.customerEmail='$cusID' AND airwaybill.airWaybillNo='$airWaybillSearch'  AND customer.customerEmail= '$cusID' ORDER BY recordDateTime DESC";

    $rs = mysqli_query($conn,$sql);

    $sql2="SELECT COUNT(*) as count FROM `airwaybilldeliveryrecord` WHERE airWaybillNo='$airWaybillSearch'";

    $rs2 = mysqli_query($conn,$sql2);

    while ($rc2=mysqli_fetch_assoc($rs2)){
        $count=$rc2['count'];
    }
    $count=$count+1;

    $search=true;

}else{ //defalult load page ,
    //get connection to db and show all lateest record of all airwaybill
    include "conn.php";
    $conn = getDBconnection();

    $cusID=$_SESSION['cusID'];

    $sql="SELECT airwaybilldeliveryrecord.airWaybillNo,MAX(airwaybilldeliveryrecord.recordDateTime) as recordDateTime , customer.customerName, airwaybill.receiverName, airwaybill.receiverPhoneNumber, airwaybill.weight,MAX(airwaybilldeliveryrecord.deliveryStatusID) as deliveryStatusID ,airwaybilldeliveryrecord.currentLocation FROM airwaybilldeliveryrecord, airwaybill,customer WHERE airwaybill.airWaybillNo = airwaybilldeliveryrecord.airWaybillNo AND airwaybill.customerEmail='$cusID' AND customer.customerEmail = '$cusID' GROUP BY airwaybillno ORDER BY recordDateTime DESC";

    $rs = mysqli_query($conn,$sql);

    $non_search=true;


}



?>
<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="image/logoWhite.png">
  <link rel="stylesheet" href="css/index.css">
  <title>Track Delivery</title>

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
  <div class="trackTable">   <!--write  things here-->
    <br>
      <form class="trackFilter" method="POST">
        <h1>Track Delivery Status</h1>
        Enter Airway Bill's No. to view delivery statuses of a parcel:
        <input type="number" name="filterID" id="filterID" required>
        <br>
        <input type="submit" value="Submit" name="submit">

          <input type="button" onclick="window.location.href='trackDelivery.php'" value="Reload">


      </form>
      

      <br>
      <div class="msg" id="msg">Table of latest info of all airwaybill:</div>
      <br>
      <div style="overflow-x: auto;">
        <table class="trackTable"  >

            <?php
            if (mysqli_num_rows($rs)!=0){
                echo "
          <tr>";
                //if is user search add record column too
            if($search==true){
                echo "<th>Record</th>";
                echo "<th>Airway bill number</th>";
            }else{
                echo "<th>Airway bill number</th>";
            }

            echo "<th>Record’s Datetime</th>
            <th>Sender’s Name</th>
            <th>Receiver’s Name</th>
            <th>Receiver’s Phone No.</th>
            <th>Parcel’s Weight</th>
            <th>Shipment Status Name</th>
            <th>Current Location</th>
          </tr>";
            }
            if ($non_search==true){
                $count=0;
            }

            //put db record in to table and print out
            while ($rc=mysqli_fetch_assoc($rs)) {
                $count--;

                //change database data from number to string
                if ($rc['deliveryStatusID']==1){
                    $deliveryStatusID="Waiting for Confirmation";
                }else if($rc['deliveryStatusID']==2){
                    $deliveryStatusID="Confirmed";
                }else if ($rc['deliveryStatusID']==3){
                    $deliveryStatusID="In Transit";
                }else if ($rc['deliveryStatusID']==4){
                    $deliveryStatusID="Delivering";
                }else if ($rc['deliveryStatusID']==5){
                    $deliveryStatusID="Completed";
                }

                //store db record to php var
                $airWaybillNo = $rc['airWaybillNo'];

                $recordDateTime = $rc['recordDateTime'];
                $customerName = $rc['customerName'];
                $receiverName = $rc['receiverName'];
                $receiverPhoneNumber = $rc['receiverPhoneNumber'];
                $weight = $rc['weight'];
                $currentLocation = $rc['currentLocation'];

                //change database data from null to string if is null
                if ($weight==null){
                    $weight="Processing";
                }else{
                    $weight = $rc['weight'];
                }

                $sql2 = "SELECT airwaybilldeliveryrecord.currentLocation FROM airwaybilldeliveryrecord,airwaybill,customer where airwaybilldeliveryrecord.recordDateTime= '$recordDateTime'  
AND airwaybill.airWaybillNo = airwaybilldeliveryrecord.airWaybillNo 
AND customer.customerEmail = airwaybill.customerEmail AND customer.customerEmail='$cusID'";
                $rs2 = mysqli_query($conn,$sql2);


                while ($rc=mysqli_fetch_assoc($rs2)) {

                    $currentLocation=$rc['currentLocation'];

                }

                //change database data from null to string if is null
                if ($currentLocation==null){
                    $currentLocation="Processing";
                }


                //print out the data
            echo "
            <tr>";

                //if is user search then fill the record column too
            if ($search==true){
                echo "<td>$count</td>";
                echo "<td>$airWaybillNo</td>";

            }else{
                echo "<td>$airWaybillNo</td>";
            }

            echo "<td>$recordDateTime</td>
            <td>$customerName</td>
            <td>$receiverName</td>
            <td>$receiverPhoneNumber</td>
            <td>$weight</td>";

                //change color for column if have special status
                if ($deliveryStatusID=="Completed"){
                    echo "<td style='background-color:green' >$deliveryStatusID</td>";
                }else if ($deliveryStatusID=="Delivering") {
                    echo "<td style='background-color:darkturquoise' >$deliveryStatusID</td>";
                }else{
                    echo "<td>$deliveryStatusID</td>";
                }
                echo "
            
            <td >$currentLocation</td>
          </tr>

            ";


             }?>
        </table>
      </div>

    <br><br><br>
  </div>

  <br>

</body>

</html>


<?php

//if customer search record then show the hints string
if ($search==true){
    ?>
    <script type="text/javascript">
        document.getElementById("msg").innerHTML="Details of airwaybill no: "+ <?php echo $airWaybillSearch ?>
        ;
    </script>
    <?php
}else if($non_search==true){ //if customer not search record then show the hints string
    ?>
    <script type="text/javascript">
        document.getElementById("msg").innerHTML="Table of latest info of all airwaybill:";
    </script>
    <?php
}

if ($search==true && mysqli_num_rows($rs)==0){ //if customer  search record but have no record, then show the hint string with color
    ?>
    <script type="text/javascript">
        const div = document.getElementById("msg");

        div.style.color = "red";
        msg.style.background = 'yellow';
        document.getElementById("msg").innerHTML="Details of airwaybill no: "+ <?php echo $airWaybillSearch ?> +" not found !"
        ;
    </script>
    <?php
}
else if  (mysqli_num_rows($rs)==0){ //if customer not search record but have no record, then show the hint string  with color
    ?>
    <script type="text/javascript">
        const div = document.getElementById("msg");

        div.style.color = "red";
        msg.style.background = 'yellow';
        document.getElementById("msg").innerHTML="There is no record";
    </script>
    <?php
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
