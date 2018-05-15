<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::dropColumn($conn, 'orderlocation', 'LocationId');
		column::addColumn($conn, 'orderlocation', 'UserId', ['foreign key' => ['column' => 'id', 'table' => 'user'], 'type' => 'int']);
		column::addColumn($conn, 'orderlocation', 'Lat', ['type' => 'double']);
		column::addColumn($conn, 'orderlocation', 'Lng', ['type' => 'double']);
		table::dropTable($conn, 'location');
	};

	$down = function($conn) {
		table::createTable($conn, 'location', ['UserId' => ['type' => 'int', 'foreign key' => ['column' => 'id', 'table' => 'user']], 'Lat' => ['type' => 'double'], 'Lng' => ['type' => 'double'], 'Id' => ['type' => 'int', 'primary key', 'auto_increment']]);
		column::dropColumn($conn, 'orderlocation', 'Lng');
		column::dropColumn($conn, 'orderlocation', 'Lat');
		column::dropColumn($conn, 'orderlocation', 'UserId');
		column::addColumn($conn, 'orderlocation', 'LocationId', ['foreign key' => ['column' => 'id', 'table' => 'Location'], 'type' => 'int']);
	};

	// column::dropColumn($conn, 'orderlocation', 'LocationId');
	// 	column::addColumn($conn, 'orderlocation', 'UserId', ['foreign key' => ['column' => 'id', 'table' => 'user'], 'type' => 'int']);
	// 	column::addColumn($conn, 'orderlocation', 'Lat', ['type' => 'double']);
	// 	column::addColumn($conn, 'orderlocation', 'Lng', ['type' => 'double']);
	// 	table::dropTable($conn, 'location');


	// table::createTable($conn, 'location', ['UserId' => ['type' => 'int', 'foreign key' => ['column' => 'id', 'table' => 'user']], 'Lat' => ['type' => 'double'], 'Lng' => ['type' => 'double'], 'Id' => ['type' => 'int', 'primary key', 'auto_increment']]);
	// 	column::dropColumn($conn, 'orderlocation', 'Lng');
	// 	column::dropColumn($conn, 'orderlocation', 'Lat');
	// 	column::dropColumn($conn, 'orderlocation', 'UserId');
	// 	column::addColumn($conn, 'orderlocation', 'LocationId', ['foreign key' => ['column' => 'id', 'table' => 'Location'], 'type' => 'int']);