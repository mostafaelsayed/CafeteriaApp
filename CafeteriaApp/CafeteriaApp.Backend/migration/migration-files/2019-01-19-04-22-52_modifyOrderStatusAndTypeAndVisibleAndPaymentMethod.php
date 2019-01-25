<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::renameColumn($conn, 'order', 'OrderStatusId', 'OrderStatus');
		column::renameColumn($conn, 'order', 'PaymentMethodId', 'PaymentMethod');
		column::modifyColumn($conn, 'order', 'OrderStatus', ['type' => 'varchar', 'max' => 100]);
		column::modifyColumn($conn, 'order', 'PaymentMethod', ['type' => 'varchar', 'max' => 100]);
		column::modifyColumn($conn, 'order', 'Type', ['type' => 'varchar', 'max' => 100]);
		column::modifyColumn($conn, 'order', 'Visible', ['type' => 'varchar', 'max' => 100]);
	};

	$down = function($conn) {
		column::modifyColumn($conn, 'order', 'Visible', ['type' => 'tinyint']);
		column::modifyColumn($conn, 'order', 'Type', ['type' => 'tinyint']);
		column::modifyColumn($conn, 'order', 'PaymentMethod', ['type' => 'int']);
		column::modifyColumn($conn, 'order', 'OrderStatus', ['type' => 'int']);
		column::renameColumn($conn, 'order', 'PaymentMethod', 'PaymentMethodId');
		column::renameColumn($conn, 'order', 'OrderStatus', 'OrderStatusId');
	};