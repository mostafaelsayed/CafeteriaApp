<?php

require_once(__DIR__ . '/../connection.php');

class table {
	public static function createTable($conn, $tableName, $object) {
		$create = "create table `$tableName` (";

		$f = [];

		// iterate over object attributes
		foreach ($object as $key => $value) {
			$f = column::constructColumnStmt($conn, $create, $key, $value, $tableName);
			$create .= ",";
		}

		if ($create[(strlen($create) ) - 1] == ',') {
			$create[(strlen($create) ) - 1] = ' ';
		}

		$create .= ");";
		$r = $conn->query($create);

		if ($r) {
			echo "table created";

			// add any primary key or foreign key
			foreach ($f as $key => $value) {
				$conn->query($value);
			}
		}
		else {
			echo "error: ", $conn->error;
		}

		exit();
	}

	public static function dropTable($conn, $tableName) {
		$setForeignKeyChecks = "set foreign_key_checks = 0";
		$drop = "drop table `$tableName`";
		$conn->query($setForeignKeyChecks);
		$conn->query($drop);
	}

	public static function renameTable($conn, $oldTableName, $newTableName) {
		$sql = "rename table {$oldTableName} to {$newTableName}";
		$res = $conn->query($sql);

		if ($res) {
			echo "table name changed";
		}
		else {
			echo "error : ", $conn->error;
		}
	}
};

class column {
	public static function constructColumnStmt($conn, &$statment, &$key, &$value, $tableName) {
		$arr = [];
		$statment .= "`$key`";

		// check type
		// $type = $value['type'];

		// if ( isset($value['type']) && $value['type'] == "varchar" && !isset($value['max']) ) {
		// 	$statment .= " varchar(255)";
		// }
		// elseif ($type == 'string') {
		// 	$statment .= " varchar";
		// }
		// elseif ($type == "int") {
		// 	$statment .= " int";
		// }
		// elseif ($type == "double") {
		// 	$statment .= " double";
		// }
		// elseif ($type == "bool") {
		// 	$statment .= " bool";
		// }
		// elseif ($type == "date") {
		// 	$statment .= " date";
		// }
		// elseif ($type == "text") {
		// 	$statment .= " text";
		// }
		if (isset($value['type'])) {
			$type = $value['type'];
			$statment .= " {$value['type']}";

			if ( isset($value['max']) ) {

				$allowedTypes = ['int', 'bigint', 'mediumint', 'smallint', 'tinyint', 'char', 'nchar', 'nvarchar', 'varchar', 'text', 'bit', 'enum', 'set'];
				// max is not associated with every datatype
				// so we must check that first
				if (in_array($type, $allowedTypes) === true) {
					$x = $value['max'];
					$statment .= "($x)";
				}
				else {
					echo "no max is set on " . $type . ". we will ignore it\n";
				}
			}
			// varchar must have max so we add default
			elseif ($type == 'varchar') {
				$statment .= "(255)";
			}
		}
		elseif (isset($value['max'])) {
			echo "error: can't have max without determining type\n";
			exit();
		}
		else {
			echo "error: you must specify type\n";
			exit();
		}

		// check if default is set
		if ( isset($value['default']) ) {
			$y = $value['default'];

			if ($value['type'] == 'date' || $value['type'] == 'datetime' || $value['type'] == 'time') {
				$statment .= " default '$y'";
			}
			else {
				$statment .= " default $y";
			}
		}

		// check other paramters
		if ( in_array("primary key", $value) ) {
			$sql = primaryKeyManager::handlePrimaryKeyAddition($conn, $tableName, $key);

			if ($sql) {
				$statment .= " primary key";
			}
		}

		if ( in_array("not null", $value) ) {
			$statment .= " not null";
		}

		if ( in_array("unique", $value) ) {
			$statment .= " unique";
		}

		if ( in_array('auto_increment', $value) ) {
			$statment .= ' auto_increment';
		}

		if ( isset($value["foreign key"]) ) {
			$key = $value['name'];
			$x = foreignKeyManager::checkForeignKeyExistence($conn, $tableName, $key);

			if ($x === false) { // no foreign key for this column
				$referencedTableName = $value['foreign key']['table'];
				$tableColumn = $value['foreign key']['column'];
				$statment .= ",";
				$foreign = helper::constructNameForIndexAndKey($tableName, $key);
				$statment .= "add constraint `$foreign` foreign key(`$key`) references `$referencedTableName`(`$tableColumn`)";
				$arr['foreign'] = $statment;
			}
		}

		return $arr;
	}

	public static function addColumn($conn, $tableName, $key, $arr) {
		$alter = "alter table `$tableName` add column ";
		$arr = column::constructColumnStmt($conn, $alter, $key, $arr, $tableName);
		$res = $conn->query($alter);

		if (!$res) {
			echo $conn->error;
		}
		else {
			echo "column {$key} added\n";
		}
		foreach ($arr as $key => $value) {
			$conn->query($value);
			if ($key == 'foreign') {
				echo "foreign key added\n";
			}
			elseif ($key == 'primary') {
				echo "primary key added\n";
			}
		}
	}

	public static function dropColumn($conn, $tableName, $key) {
		$foreign = foreignKeyManager::checkForeignKeyExistence($conn, $tableName, $key);

		if ($foreign) {
			foreignKeyManager::dropForeignKey($conn, $tableName, $key);
		}

		$alter = "alter table `$tableName` drop column `$key`";
		$result = $conn->query($alter);

		if ($result) {
			echo "column {$key} deleted\n";
		}
		else {
			echo "error: ", $conn->error, "\n";
		}
	}

	// update every value for that column
	public static function modifyColumn($conn, $tableName, $key, $column) {
		$arr = objectTableMapper::getTableColumns($conn, $tableName);
		$columnAttrs = $arr[$key];
		$alter = "alter table `$tableName` modify column `$key`";
		// some errors to handle before moving on
		// auto_increment and default
		if (key_exists('default', $column) === true && key_exists('auto_increment', $column) === true && $column['default'] === true && $column['auto_increment'] === true) {
			echo "can't add default and auto_increment at the same time";
			return;
		}

		$type = 0;

		if (array_key_exists('type', $column) === true) {
			$type = $column['type'];
			$alter .= " {$type}";

			if (array_key_exists('max', $column) === true) {
				$alter .= "({$column['max']})";
			}
			elseif (array_key_exists('max', $columnAttrs) === true) {
				$alter .= "({$columnAttrs['max']})";
			}

		}
		else {
			$type = $columnAttrs['type'];
			$alter .= " {$type}";

			if (array_key_exists('max', $column) === true) {
				$alter .= "({$column['max']})";
			}
			elseif (array_key_exists('max', $columnAttrs) === true) {
				$alter .= "({$columnAttrs['max']})";
			}
		}

		if (array_key_exists('unique', $column) === true) {
			$uni = "select * from `information_schema`.`table_constraints` where `constraint_type` = 'unique' and `CONSTRAINT_NAME` = '$key' and `table_name` = '$tableName'";
			$r = $conn->query($uni);
			$r1 = mysqli_fetch_array($r, MYSQLI_ASSOC);

			if (!$r) {
				echo $conn->error;
				return;
			}

			if ($column['unique'] === false) {
				$res = $conn->query("alter table `$tableName` drop index `$key`");

				if (!$res) {
					echo "index not found on {$key} column\n";
					exit();
				}
			}
			elseif ($r1 !== null && $column['unique'] === true) {
				echo "unique already set on column {$key}\n";
				exit();
			}
			elseif ($r1 === null) {
				$s = "alter table `$tableName` add unique(`$key`)";
				$r = $conn->query($s);

				if (!$r) {
					echo $conn->error;
				}
			}
		}

		// 2- not null
		if ( array_key_exists('not null', $column) ) {
			if ($column['not null'] === true) {
				$alter .= " not null";
			}
			elseif ($column['not null'] === false) {
				$alter .= " null";
			}
			else {
				echo "not null must be either true or false";
				exit();
			}
		}
		elseif (in_array('not null', $columnAttrs) === true) {
			$alter .= " not null";
		}


		if (array_key_exists('default', $column) === true && $column['default'] === false
		&& array_key_exists('auto_increment', $column) === true && $column['auto_increment'] === false) {

		}
		elseif (array_key_exists('default', $column) === true && $column['default'] !== false) {
			if (array_key_exists('auto_increment', $column) === true && $column['auto_increment'] === false) {
				if ($type == 'date' || $type == 'time' || $type == 'datetime') {
					$alter .= " default '{$column['default']}'";
				}
				else {
					$alter .= " default " . $column['default'];
				}
			}
			elseif (in_array('auto_increment', $columnAttrs) === true) {
				echo "remove auto_increment first";
				exit();
			}
			else {
				if ($type == 'date' || $type == 'time' || $type == 'datetime') {
					$alter .= " default '{$column['default']}'";
				}
				else {
					$alter .= " default " . $column['default'];
				}
			}
		}
		elseif (array_key_exists('auto_increment', $column) === true && $column['auto_increment'] === true) {
			if (array_key_exists('default', $column) === true && $column['default'] === false) {
				$alter .= " auto_increment";
			}
			elseif (array_key_exists('default', $columnAttrs) === true) {
				echo "remove default first";
				exit();
			}
			else {
				$alter .= " auto_increment";
			}
		}

		$r = $conn->query($alter);

		if (!$r) {
			echo $conn->error;
		}
		else {
			echo "column {$key} modified\n";
		}
	}

	public static function renameColumn($conn, $tableName, $oldColumnName, $newColumnName) {
		$arr = objectTableMapper::getTableColumns($conn, $tableName);
		$columnAttrs = $arr[$oldColumnName];
		$alter = "alter table `$tableName` change column `$oldColumnName` `$newColumnName`";

		$alter .= " {$columnAttrs['type']}"; // type
		$alter .= "({$columnAttrs['max']})"; // max

		if (in_array('not null', $columnAttrs) === true) {
			$alter .= " not null";
		}

		if (in_array('auto_increment', $columnAttrs) === true) {
			$alter .= " auto_increment";
		}

		if (array_key_exists('default', $columnAttrs) === true) {
			$alter .= " default '{$columnAttrs['default']}'";
		}

		$r = $conn->query($alter);

		if (!$r) {
			echo $conn->error;
		}
	}
};

class primaryKeyManager {
	public static function handlePrimaryKeyAddition($conn, $tableName, $key) { // when add table
		// check if there is no primary key in this table first
		// check if not table
		if ($conn->query("select 1 from `$tableName` limit 1") === false || mysqli_fetch_assoc( $conn->query("select 1 from `$tableName` limit 1") )['num_rows'] == 0) {
				$sql = "ALTER TABLE `$tableName` ADD CONSTRAINT PRIMARY KEY (`$key`);";

				return $sql;
			}
			else {
				$pr = "SHOW INDEXES FROM `$tableName` WHERE Key_name = 'PRIMARY'";
				$pr1 = $conn->query($pr);

				if (!$pr1) {
					echo "error: ", $conn->error;
				}
			}
	}

	public static function addPrimaryKey($conn, $tableName, $key) { // when update column
		$sql = "ALTER TABLE `$tableName` ADD CONSTRAINT PRIMARY KEY (`$key`);";
		$res = $conn->query($sql);

		if ($res) {
			echo "primary key added";
		}
		else {
			echo $conn->error;
		}
	}

	public static function dropPrimaryKey($conn, $tableName, $key = null) {
		$sql = "SELECT * FROM `information_schema`.`KEY_COLUMN_USAGE` WHERE `REFERENCED_TABLE_NAME` = '$tableName' AND `REFERENCED_COLUMN_NAME` = '$key'";
		$r = mysqli_fetch_assoc( $conn->query($sql) );

		if ( !($r !== null) ) {
			$c = "alter table `$tableName` drop primary key";
			$z = $conn->query($c);

			if ($z) {
				echo "primary key droppped";
			}
			else {
				echo "error: ", $conn->error, "\n";
			}
		}
		else {
			echo "primary key can't be dropped because it's referenced from another table";
		}
	}
};

class foreignKeyManager {
	public static function checkForeignKeyExistence($conn, $tableName, $key) {
		$sql = "select `constraint_name` from `INFORMATION_SCHEMA`.`KEY_COLUMN_USAGE` where `column_name` = '$key' and `table_name` = '$tableName'";
		$s = $conn->query($sql);
		$r = mysqli_fetch_all($s);

		foreach ($r as $key => $value) {
			foreach ($value as $k => $v) {
				if (strpos($v, '_ibfk_') !== false) { // foreign
					return $v;
				}
			}
		}

		return false;
	}

	public static function addForeignKey($conn, $tableName, $column, $referencedTable, $referencedColumn) {
		$sql = "ALTER TABLE `$tableName` ADD CONSTRAINT FOREIGN KEY (`$column`) REFERENCES `$referencedTable`(`$referencedColumn`);";
		$res = $conn->query($sql);
		var_dump($sql);

		if ($res) {
			echo "foreign key added";
		}
		else {
			echo "error: ", $conn->error;
		}
	}

	public static function dropForeignKey($conn, $tableName, $key) {
		$f = foreignKeyManager::checkForeignKeyExistence($conn, $tableName, $key);
		$sql = "alter table `$tableName` drop foreign key $f";
		$r = $conn->query($sql);

		if ($r) {
			echo "foreign key dropped";
		}
		else {
			echo $conn->error;
		}
	}
};

class indexManager {
	public static function createIndex($conn, $tableName, $index, $columnToIndexTo) {
		$sql = "ALTER TABLE `$tableName` ADD INDEX `$index` (`$columnToIndexTo` ASC);";
		$res = $conn->query($sql);

		if ($res) {
			echo "index added";
		}
		else {
			echo "error: ", $conn->error;
		}
	}

	public static function dropIndex($conn, $tableName, $index) {
		$sql = "ALTER TABLE `$tableName` DROP INDEX `$index`";
		$res = $conn->query($sql);

		if ($res) {
			echo "index dropped";
		}
		else {
			echo "error: ", $conn->error;
		}
	}
};

class objectTableMapper {
	public static function getTableColumns($conn, $tableName) {
		$result = $conn->query("show columns from `$tableName`");
		$arr = [];
		$flag = 0;

		while ( $row = mysqli_fetch_assoc($result) ) {
			$arr[$row['Field']] = [];

			if (strpos($row['Type'], "int") !== false && strpos($row['Type'], "tiny") === false) {
				$arr[$row['Field']]['type'] = "int";
			}
			elseif (strpos($row['Type'], "varchar") !== false) {
				$arr[$row['Field']]['type'] = "varchar";
			}
			elseif (strpos($row['Type'], "date") !== false) {
				$arr[$row['Field']]['type'] = "date";
			}
			elseif (strpos($row['Type'], "time") !== false) {
				$arr[$row['Field']]['type'] = "time";
			}
			elseif (strpos($row['Type'], "tinyint") !== false) {
				$arr[$row['Field']]['type'] = "bool";
			}
			elseif (strpos($row['Type'], "text") !== false) {
				$arr[$row['Field']]['type'] = "text";
			}
			elseif (strpos($row['Type'], "double") !== false) {
				$arr[$row['Field']]['type'] = "double";
			}

			if (strpos($row['Type'], "(") !== false && strpos($row['Type'], "tinyint") === false) {
				$start = strpos($row['Type'], "(");
				$end = strpos($row['Type'], ")");
				$length = $end - $start;
				$max = substr($row['Type'], $start + 1, $length - 1);
				$arr[$row['Field']]['max'] = $max;
			}

			if ($row['Null'] == "NO") {
				array_push($arr[$row['Field']], "not null");
			}

			if ($row['Key'] == "PRI") {
				array_push($arr[$row['Field']], "primary key");
			}
			elseif ($row['Key'] == "UNI") {
				array_push($arr[$row['Field']], "unique");
			}

			if ($row['Default'] !== null && $row['Default'] !== "") {
				$x = $row['Default'];
				$arr[$row['Field']]['default'] = "$x";
			}

			if ($row['Extra'] !== null && $row['Extra'] !== "") {
				$x = $row['Extra'];
				array_push($arr[$row['Field']], $x);
			}
		}
		
		return $arr;
	}
};