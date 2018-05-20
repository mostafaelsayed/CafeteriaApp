<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::addColumn($conn, 'user', 'CroppedImage', ['type' => 'text']);
	};

	$down = function($conn) {
		column::dropColumn($conn, 'user', 'CroppedImage');
	};