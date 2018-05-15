<?php
	require_once(__DIR__ . '/../migration-classes.php');
	require_once(__DIR__ . '/../migrator.php');

	$migrator = new migrator();

	$up = function($conn) {
		column::modifyColumn($conn, 'Order', 'DeliveryFee', ['default' => 0.00]);
		column::modifyColumn($conn, 'Order', 'TaxFee', ['default' => 0.00]);
	};

	$down = function($conn) {
		column::modifyColumn($conn, 'Order', 'TaxFee', ['default' => null]);
		column::modifyColumn($conn, 'Order', 'DeliveryFee', ['default' => null]);
	};
	