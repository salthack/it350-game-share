<?php
session_start();


if (isset($_COOKIE["username"])) {
	setcookie("username", "", time()-3600);
//	unset($_SESSION['auth']);
	session_destroy();
	header( 'Location: login.php' );
}
else {
//	unset($_SESSION['auth']);
	session_destroy();
	header( 'Location: login.php' );
    }
    
?>