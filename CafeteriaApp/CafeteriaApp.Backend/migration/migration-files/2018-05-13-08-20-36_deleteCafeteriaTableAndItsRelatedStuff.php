<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::dropColumn($conn, 'category', 'CafeteriaId');
		table::dropTable($conn, 'cafeteria');
	};

	$down = function($conn) {
		table::createTable($conn, 'cafeteria', ['Id' => ['type' => 'int', 'primary key', 'auto_increment'], 'Name' => ['type' => 'varchar'], 'Image' => ['type' => 'text']]);
		column::addColumn($conn, 'category', 'CafeteriaId', ['type' => 'int', 'foreign key' => ['table' => 'cafeteria', 'column' => 'Id']]);
	};
	