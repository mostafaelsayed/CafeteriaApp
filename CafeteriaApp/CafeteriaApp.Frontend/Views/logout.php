<?php require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies ?> 
<?php require_once("CafeteriaApp.Backend/functions.php"); ?>

<!-- <?php
	// v1: simple logout
	// session_start();
	//$_SESSION["user_id"] = null;
	//$_SESSION["user_name"] = null;
	//$_SESSION["customer_id"] = null;

	//redirect_to("login.php");
?> -->

<?php
	// v2: destroy session
	// assumes nothing else in session to keep
	// session_start();
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
	  setcookie(session_name(), null, time()-42000, '/');
	}
	session_destroy(); 
	redirect_to("login.php");
?>
