<?php
	require('../Controllers/Branch.php');
	require('../connection.php');
	require('TestRequestInput.php');

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	    checkResult( getBranches($conn) );
	}

	require('../footer.php');
?>