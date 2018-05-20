<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::addColumn($conn, 'user', 'ImageSet', ['type' => 'tinyint', 'default' => 1, 'max' => 2]);
	};

	$down = function($conn) {
		column::dropColumn($conn, 'user', 'ImageSet');
	};
	