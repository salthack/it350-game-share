<?php
session_start();
require("connect.php");
if (!$_SESSION['e_auth'] == 1) {
    // check if authentication was performed
  header( 'Location: employee_login.php?message=2' );
}

if ((!empty($_POST["status"])) && (!empty($_POST["returnID"])) && (!empty($_POST["gameID"])) && (!empty($_POST["cusID"]))  ){
	$con = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);
	if (mysqli_connect_errno()) {
   printf("Connect failed: %s\n", mysqli_connect_error());
   exit();  
 }
//POST vars
 $recordID = uniqid('recordID_', false);
 $status = mysqli_real_escape_string($con, $_POST['status']);
 $returnID = mysqli_real_escape_string($con, $_POST['returnID']);
 $gameID = mysqli_real_escape_string($con, $_POST['gameID']);
 $cusID = mysqli_real_escape_string($con, $_POST['cusID']);

//If game disposed, dispose it
 if($status == 'disposed'){
  		//make disposal
  $insertDispose = "INSERT INTO Disposal VALUES ('".$recordID."','".$gameID."')";
  if (!mysqli_query($con,$insertDispose)) {
    die('Error: ' . mysqli_error($con));
  }

  		//update game to dispose
  $updateGame = "UPDATE Game SET status='DISPOSED', game_condition='disposed' WHERE gameID = '".$gameID."'";
  if (!mysqli_query($con,$updateGame)) {
    die('Error: ' . mysqli_error($con));
  }

  		//delete return
  $removeRet = "DELETE FROM Returns WHERE returnID='".$returnID."'";
  if (!mysqli_query($con,$removeRet)) {
    die('Error: ' . mysqli_error($con));
  }


}
else{
  //Or don't dispose it
  		//update game to contition and IN
  $updateGame = "UPDATE Game SET status='IN', game_condition='".$status."' WHERE gameID = '".$gameID."'";
  if (!mysqli_query($con,$updateGame)) {
    die('Error: ' . mysqli_error($con));
  }

  		//delete return
  $removeRet = "DELETE FROM Returns WHERE returnID='".$returnID."'";
  if (!mysqli_query($con,$removeRet)) {
    die('Error: ' . mysqli_error($con));
  }


}

mysqli_close($con);

header( 'Location: employee_management.php' );

}
else{
	header( 'Location: employee_management.php' );
}

?>