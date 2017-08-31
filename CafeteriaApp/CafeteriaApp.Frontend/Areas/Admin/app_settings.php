<?php

	require_once("CafeteriaApp.Backend/functions.php");

   	validatePageAccess($conn);

	require_once('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<div>

	<head>

		<title>App Settings</title>

	</head>

	<h1 class="page-header">Manage Your App Settings</h1>

	<a href="/CafeteriaApp.Frontend/Areas/Admin/AppSettings/Views/show_and_delete_fees.php" style="margin: auto">

		Fees
		
	</a>

</div>