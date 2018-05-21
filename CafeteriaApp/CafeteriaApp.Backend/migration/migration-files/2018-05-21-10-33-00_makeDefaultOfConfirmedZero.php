<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::modifyColumn($conn, 'user', 'Confirmed', ['default' => 0]);
	};

	$down = function($conn) {
		column::modifyColumn($conn, 'user', 'Confirmed', ['default' => 1]);
	};
	