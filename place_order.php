<?php
session_start();
require("connect.php");
if (!$_SESSION['auth'] == 1) {
    // check if authentication was performed

    header( 'Location: login.php?message=2' );
}

if ((!empty($_POST["orderID"])) && (!empty($_POST["title"])) && (!empty($_POST["price"])) && (!empty($_POST["gameID"])) && (!empty($_POST["status"])) && (!empty($_POST["cusID"])) && (!empty($_POST["empID"]))  ){
	$con = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);
	
	if (mysqli_connect_errno()) {
    	printf("Connect failed: %s\n", mysqli_connect_error());
    	exit();  
  	}

  	$orderID = mysqli_real_escape_string($con, $_POST['orderID']);
  	$title = mysqli_real_escape_string($con, $_POST['title']);
  	$price = mysqli_real_escape_string($con, $_POST['price']);
  	$gameID = mysqli_real_escape_string($con, $_POST['gameID']);
  	$status = mysqli_real_escape_string($con, $_POST['status']);
  	$cusID = mysqli_real_escape_string($con, $_POST['cusID']);
  	$empID = mysqli_real_escape_string($con, $_POST['empID']);

  	$insertQ = "INSERT INTO Orders VALUES ('".$orderID."','".$title."', '".$price."','".$gameID."','".$status."','".$cusID."','".$empID."')";

    if (!mysqli_query($con,$insertQ)) {
      die('Error: ' . mysqli_error($con));
    }

    mysqli_close($con);

    header( 'Location: index.php' );




}

?>