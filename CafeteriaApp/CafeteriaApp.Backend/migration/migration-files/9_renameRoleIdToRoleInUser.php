<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::renameColumn($conn, 'user', 'RoleId', 'Role');
	};

	$down = function($conn) {
		column::renameColumn($conn, 'user', 'Role', 'RoleId');
	};
	