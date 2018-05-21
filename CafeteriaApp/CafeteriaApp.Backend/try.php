<?php


require 'connection.php';

require 'migration/migration-classes.php';

global $reversers;
$reversers = [];

//echo function_exists('random_bytes');


//echo pathinfo('/x/y.jpg', PATHINFO_EXTENSION);

//echo dirname(__FILE__);

// var_dump(objectTableMapper::getTableColumns($conn, 'user'));

//table::createTable($conn, 'try', ['Id' => ['primary key', 'auto_increment', 'type' => 'int', 'foreign key' => ['column' => 'Id', 'table' => 'user']]]);

// column::modifyColumn($conn, 'try', 'Id', ['foreign key' => false]);
column::modifyColumn($conn, 'try', 'Id', ['primary key' => false]);
//table::dropTable($conn, 'try');