<?php
session_start();
require("connect.php");
if (!$_SESSION['auth'] == 1) {
    // check if authentication was performed
  header( 'Location: login.php?message=2' );
}
//Vars needed
if ((!empty($_POST["orderID"])) && (!empty($_POST["gameID"])) && (!empty($_POST["cusID"]))  ){
	$con = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);
	if (mysqli_connect_errno()) {
   printf("Connect failed: %s\n", mysqli_connect_error());
   exit();  
 }

//Sanitize Vars
 $returnID = uniqid('returnID_', false);
 $orderID = mysqli_real_escape_string($con, $_POST['orderID']);
 $gameID = mysqli_real_escape_string($con, $_POST['gameID']);
 $cusID = mysqli_real_escape_string($con, $_POST['cusID']);

  	//Make return
 $insertReturn = "INSERT INTO Returns VALUES ('".$returnID."','".$gameID."', '".$cusID."')";
 if (!mysqli_query($con,$insertReturn)) {
  die('Error: ' . mysqli_error($con));
}

    //Update Game
$updateGame = "UPDATE Game SET status='RETURNED' WHERE gameID = '".$gameID."'";
if (!mysqli_query($con,$updateGame)) {
  die('Error: ' . mysqli_error($con));
}

    //Remove Order
$removeOrder = "DELETE FROM Orders WHERE gameID='".$gameID."' AND cusID = '".$cusID."'";
if (!mysqli_query($con,$removeOrder)) {
  die('Error: ' . mysqli_error($con));
}


header( 'Location: index.php' );



mysqli_close($con);


}
else{
 header( 'Location: index.php' );
}


?>