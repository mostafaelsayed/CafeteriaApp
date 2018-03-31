<?php
	require(__DIR__.'/../connection.php');
	require(__DIR__.'/../Controllers/Admin.php');
	require(__DIR__.'/TestRequestInput.php');

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$data = json_decode( file_get_contents('php://input') );

		if ( isset($data->UserId) && test_int($data->UserId) ) {
			addAdmin($conn, $data->UserId);
		}
	}

	if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
		if ( isset($_GET['userId']) && test_int($_GET['userId']) ) {
			deleteAdminByUserId($conn, $_GET['userId']);
		}
	}

	require('../footer.php');
?>