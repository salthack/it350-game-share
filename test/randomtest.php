<?php
require("connect.php");

$empCon = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);

if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();  
}

$empRes = mysqli_query($empCon,"SELECT empID FROM Employee");

//var_dump($empRes);

$IDs = array();
while ($row = mysqli_fetch_array($empRes)){
	array_push($IDs, $row['empID']);
}
$randID = rand(0,sizeof($IDs)-1);

var_dump($IDs);

echo $IDs[$randID];
mysqli_close($empCon);

?>