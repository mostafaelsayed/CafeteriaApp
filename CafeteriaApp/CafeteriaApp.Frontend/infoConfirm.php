<?php 
	require_once(__DIR__ . '/../CafeteriaApp.Backend/session.php');
	require_once(__DIR__ . '/../CafeteriaApp.Backend/connection.php');
	require(__DIR__ . '/../CafeteriaApp.Backend/Controllers/Customer.php');
	require(__DIR__ . '/../CafeteriaApp.Backend/Controllers/User.php');

	if ( isset($_SESSION['userId']) ) {
		echo nl2br("Account\r\Activated\r\n!"); 
		//from user
		$acc = $_GET['acc'];
		$hashKey = $_GET['hashKey']; 

		//from db
		$userId = $_SESSION['userId'];
		$customer = getCustomerByUserId($conn, $userId);
	 	$acc2 = hash("sha256", $user_id, false);
	 	$hashKey2 = hash("sha256", $customer['Id'] . $customer['DateOfBirth'] . $userId . $customer['GenderId'], false);
		
		if ($acc === $acc2 && $hashKey === $hashKey2) {
			if ( activateUser($conn, $userId) ) {
				header( "Location:" . rawurldecode("../Areas/Public/Cafeteria/Views/showing cafeterias.php") );	
			}
		}
		else {
			echo "<h2>Activation Failed !. please, contact customer care.</h2>";
		}
	}

	//echo 0 === null;
	//echo 0 == null; // false true
	//print_r(json_encode( array("Id"=>5, "Duration"=>50) ) )
?>