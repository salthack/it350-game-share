<?php
session_start();
ini_set('display_errors',"1");
if ( (!(isset($_SESSION['e_auth']))) && (isset($_COOKIE["e_username"]))) {
    // check if authentication was performed

  header( 'Location: employee_logout.php' );
}
require("connect.php");

$con = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if( (isset($_POST['eloginName'])) || (isset($_POST['eloginPassword'])) ) {
  
  if (empty($_POST['eloginName'])) {
    header( 'Location: employee_login.php?message=1' );
  }
  if (empty($_POST['eloginPassword'])) {
    header( 'Location: employee_login.php?message=1' );
  } 
  
  $query = "SELECT * FROM Employee WHERE username = '" . mysqli_real_escape_string($con, $_POST['eloginName']) . "' AND pass = SHA1('" . mysqli_real_escape_string($con, $_POST['eloginPassword']) . "')";
  $result = mysqli_query($con, $query);

  if (mysqli_num_rows($result) == 1) {


    $_SESSION['e_auth'] = 1;
    setcookie("e_username", $_POST['eloginName'], time()+(84600*30));
    $_SESSION['e_name'] = $_POST['eloginName'];
    header( 'Location: employee_management.php' );
  }
  else {

    header( 'Location: employee_login.php?message=1' );
  }
  
    mysqli_free_result($result);
  
    mysqli_close($con);
} 
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Employee Login Form</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/index-script.js"></script>
	</head>
	<body>
<!--login modal-->

<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div id="loginform" class="modal-content">
      <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
          <h1 class="text-center">GameShare Employee Login</h1>
      </div>
<?php

$mes;
if(empty($_GET['message'])){
  $mes=0;
}
else{
  $mes=$_GET['message'];
}
switch ($mes){
  case 1:{
    echo "<div class='panel panel-danger'>";
    echo "<div class='panel-heading'>";
    echo "<h3 class='panel-title'>Notice</h3>";
    echo "</div>";
    echo "<div class='panel-body'>";
    echo "Login Failed!";
    echo "</div>";
    echo "</div>";
    break;
  }
  case 2:{
    echo "<div class='panel panel-danger'>";
    echo "<div class='panel-heading'>";
    echo "<h3 class='panel-title'>Notice</h3>";
    echo "</div>";
    echo "<div class='panel-body'>";
    echo "Please Login";
    echo "</div>";
    echo "</div>";
    break;
  }
  case 3:{
    echo "<div class='panel panel-danger'>";
    echo "<div class='panel-heading'>";
    echo "<h3 class='panel-title'>Notice</h3>";
    echo "</div>";
    echo "<div class='panel-body'>";
    echo "Registration Successfull, Please Login.";
    echo "</div>";
    echo "</div>";
    break;
  }
  default:{
    echo "<div class='panel panel-danger'>";
    echo "<div class='panel-heading'>";
    echo "<h3 class='panel-title'>Notice</h3>";
    echo "</div>";
    echo "<div class='panel-body'>";
    echo "Please Login";
    echo "</div>";
    echo "</div>";  }
}

?>


      <div class="modal-body">
          <form class="form col-md-12 center-block" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="eloginName" placeholder="Username">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" name="eloginPassword" placeholder="Password">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-lg btn-block">Employee Login</button>
            </div>
          </form>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button> -->
		  </div>	
      </div>
  </div>
  </div>
</div>
	<!-- script references -->

	</body>
</html>