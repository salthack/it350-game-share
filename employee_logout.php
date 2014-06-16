<?php
session_start();

//Kill the session
if (isset($_COOKIE["e_username"])) {
	setcookie("e_username", "", time()-3600);
//	unset($_SESSION['auth']);
	session_destroy();
	header( 'Location: employee_login.php' );
}
else {
//	unset($_SESSION['auth']);
	session_destroy();
	header( 'Location: employee_login.php' );
}

?>