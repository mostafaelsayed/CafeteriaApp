<?php
	if ( !session_id() ) {
    	session_start();

    	if ( empty($_SESSION['csrf_token'])) {
		    $_SESSION['csrf_token'] = bin2hex( random_bytes(32) );
		}

		//$token = $_SESSION['token'];
	}
	
	// to use session to send a message to another page
	function message() {
		if ( isset($_SESSION['message']) ) {
			$output = "<div class=\"error\">";
			$output .= ($_SESSION['message']);
			$output .= "</div>";
			
			// clear message after use
			$_SESSION['message'] = null;
			
			return $output;
		}
	}

	// to use session to send a errors messages to another page
	function errors() {
		if ( isset($_SESSION['errors']) ) {
			$errors = $_SESSION['errors'];
			
			// clear message after use
			$_SESSION['errors'] = null;
			
			return $errors;
		}
	}	
?>