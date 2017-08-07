<?php 	
//require_once("CafeteriaApp.Backend/Controllers/User.php"); 
 require_once('CafeteriaApp.Backend/session.php');
 require_once("CafeteriaApp.Backend/connection.php"); 


	function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}


	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\" style=\"color: red; font-weight:bold;\"> ";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	
	

	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}

	
	function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);
	  
		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}
	
	

	function islogged_in() {
		return isset($_SESSION['admin_id']);
	}
	
	function confirm_logged_in() {
		if (!islogged_in()) {
			redirect_to("login.php");
		}
	}



function attempt_login($conn,$email, $password) {
    $user = getUserByEmail($conn , $email);
    if ($user) {
      // found user, now check password
      if (passwordCheck($password, $user["PasswordHash"])) {
        // password matches
        return $user;
      } else {
        // password does not match
        return false;
      }
    } else {
      // user not found
      return false;
    }
  }


function getUserByEmail($conn,$email) {    
   if (!isset($email))
  {
     echo "Error: User Email is not set";
  return;
  }
  else{
    $safe_email = mysqli_real_escape_string($conn, $email);
    
    $query  = "SELECT * ";
    $query .= "FROM User ";
    $query .= "WHERE Email = '{$safe_email}' ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($conn, $query);
    confirmQuery($user_set);
    if($user = mysqli_fetch_assoc($user_set)) {
      return $user;
    } else {
      return null;
    }
  }}
  

function confirmQuery($result_set) {
    if (!$result_set) {
      die("Database query failed."); //  not give the user who wants to login any info
    }
  }



  function passwordCheck($password, $existing_hash) {
    // existing hash contains format and salt at start
    $hash = crypt($password, $existing_hash);
    if ($hash === $existing_hash) {
      return true;
    } else {
      return false;
    }
  }



//***************************			to be continued			 ********************************************
function validatePageAccess ($conn) {/*, $existing_hash*/
    // existing hash contains format and salt at start
    //$hash = crypt($pageName, $existing_hash);
    //$safe_email = mysqli_real_escape_string($conn, $email);
    $query  = "SELECT `Dir` FROM `Dir` WHERE Id IN (SELECT DirId FROM Dir_Role WHERE RoleId= {$_SESSION["roleId"]} ) ";  // add RoleId index to the session var  on login

    $result_set = mysqli_query($conn, $query);
    confirmQuery($result_set);
    if($result_set) {
    //$result_no = mysqli_num_rows($result_set);
    $dirs = mysqli_fetch_all($result_set, MYSQLI_ASSOC); // ??
	//print_r($dirs);
	foreach ($dirs as $key => $value) {
	
    if ( strpos(getcwd() , $value["Dir"]) !== false ){
    	
      return;
    }
	}

    echo "<h1 style ='color:red;' > Access denied . </h2>";
    exit(); 
    }

  }



?>

