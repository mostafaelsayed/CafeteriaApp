<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::addColumn($conn, 'user', 'Gender', ['type' => 'int', 'not null', 'default' => 1]);
		column::addColumn($conn, 'user', 'DateOfBirth', ['type' => 'date', 'not null', 'default' => '2018-05-05']);
	};

	$down = function($conn) {
		column::dropColumn($conn, 'user', 'DateOfBirth');
		column::dropColumn($conn, 'user', 'Gender');
	};
	