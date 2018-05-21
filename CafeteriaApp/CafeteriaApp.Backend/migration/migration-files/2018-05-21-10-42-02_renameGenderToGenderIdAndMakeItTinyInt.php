<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::renameColumn($conn, 'user', 'Gender', 'GenderId');
		column::modifyColumn($conn, 'user', 'GenderId', ['type' => 'tinyint', 'max' => 2]);
	};

	$down = function($conn) {
		column::modifyColumn($conn, 'user', 'GenderId', ['type' => 'int', 'max' => 11]);
		column::renameColumn($conn, 'user', 'GenderId', 'Gender');
	};
	