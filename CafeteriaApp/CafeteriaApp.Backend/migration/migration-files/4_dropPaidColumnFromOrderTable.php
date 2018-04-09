<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::dropColumn($conn, 'order', 'Paid');
	};

	$down = function($conn) {
		column::addColumn($conn, 'order', 'Paid');
	};
	