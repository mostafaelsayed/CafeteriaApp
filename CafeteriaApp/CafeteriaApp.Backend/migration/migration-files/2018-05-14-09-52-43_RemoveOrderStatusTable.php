<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		foreignKeyManager::dropForeignKey($conn, 'order', 'OrderStatusId');
		table::dropTable($conn, 'orderstatus');
	};

	$down = function($conn) {
		table::createTable($conn, 'orderstatus', ['Id' => ['type' => 'int', 'not null', 'auto_increment', 'primary key'], 'Name' => ['type' => 'varchar', 'max' => '100', 'not null']]);
		foreignKeyManager::addForeignKey($conn, 'order', 'OrderStatusId', 'orderstatus', 'Id');
	};
	