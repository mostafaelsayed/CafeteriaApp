<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::dropColumn($conn, 'customer', 'DateOfBirth');
		column::dropColumn($conn, 'customer', 'Gender');
	};

	$down = function($conn) {
		column::addColumn($conn, 'customer', 'Gender', ['type' => 'int', 'not null']);
		column::addColumn($conn, 'customer', 'DateOfBirth', ['type' => 'date', 'not null']);
	};
	