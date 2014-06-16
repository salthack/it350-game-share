<?php
session_start();
require("connect.php");
if (!$_SESSION['e_auth'] == 1) {
    // check if authentication was performed
  header( 'Location: employee_login.php?message=2' );
}
//Vars needed
if ((!empty($_POST["compID"])) && (!empty($_POST["orderID"])) && (!empty($_POST["gameID"])) && (!empty($_POST["empID"]))  ){
	$con = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);
	if (mysqli_connect_errno()) {
   printf("Connect failed: %s\n", mysqli_connect_error());
   exit();  
 }

//Sanitize Vars
 $shipID = uniqid('shipID_', false);
 $orderID = mysqli_real_escape_string($con, $_POST['orderID']);
 $gameID = mysqli_real_escape_string($con, $_POST['gameID']);
 $empID = mysqli_real_escape_string($con, $_POST['empID']);
 $compID = mysqli_real_escape_string($con, $_POST['compID']);


  	//Make shippment
 $insertShip = "INSERT INTO Shipment VALUES ('".$shipID."','".$gameID."', '".$compID."')";
 if (!mysqli_query($con,$insertShip)) {
  die('Error: ' . mysqli_error($con));
}

    //sends table
$insertSends = "INSERT INTO Sends VALUES ('".$empID."','".$shipID."', CURDATE())";
if (!mysqli_query($con,$insertSends)) {
  die('Error: ' . mysqli_error($con));
}

    //Update Game to status SENT
$updateGame = "UPDATE Game SET status='SENT' WHERE gameID = '".$gameID."'";
if (!mysqli_query($con,$updateGame)) {
  die('Error: ' . mysqli_error($con));
}

    //Update Order to Sent
$updateOrder = "UPDATE Orders SET status='Sent' WHERE orderID = '".$orderID."'";
if (!mysqli_query($con,$updateOrder)) {
  die('Error: ' . mysqli_error($con));
}


mysqli_close($con);

header( 'Location: employee_management.php' );

}
else{
 header( 'Location: employee_management.php' );
}

?>