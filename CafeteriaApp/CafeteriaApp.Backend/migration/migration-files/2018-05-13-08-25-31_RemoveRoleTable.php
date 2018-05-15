<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::modifyColumn($conn, 'customer', 'Credit', ['default' => 0.00]);
	};

	$down = function($conn) {
		column::modifyColumn($conn, 'customer', 'Credit', ['default' => false]);
	};
	