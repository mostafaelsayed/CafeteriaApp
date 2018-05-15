<?php

require_once(__DIR__ . '/../connection.php');

function runReversers() {
	$len = count($GLOBALS['reversers']);

	for ($i = $len - 1; $i >= 0; $i--) {
		$GLOBALS['reversers'][$i]();
	}

	exit();
}

class table {
	public static function createTable($conn, $tableName, $object, $rev = 0) {
		$create = "create table `$tableName` (";

		$f = [];

		// iterate over object attributes
		foreach ($object as $key => $value) {
			$x = column::constructColumnStmtForCreateTable($conn, $create, $key, $value, $tableName);

			foreach ($x as $k => $v) {
				//var_dump($k);
				//var_dump($v);
				array_push($f, $k);
			}

			//var_dump($f);

			$create .= ",";
		}

		if ($create[(strlen($create) ) - 1] == ',') {
			$create[(strlen($create) ) - 1] = ' ';
		}

		$create .= ");";
		$r = $conn->query($create); // create table

		if ($r) {
			if ($rev == 0) {
				echo "table created\n";
			}

			$reverser = function() use($conn, $tableName) {
				table::dropTable($conn, $tableName, 1);
			};

			array_push($GLOBALS['reversers'], $reverser);

			// add any primary key or foreign key
			foreach ($f as $key => $value) {
				if ($value === 'primary') {
					if ($rev == 0) {
						echo "primary key added\n";
					}
				}
				else {
					$f = $conn->query($value[0]);

					if ($f) {
						if ($rev == 0) {
							echo "foreign key added on {$value[1]} column\n";
						}
					}
					else {
						if ($rev == 1) {
							echo "stuck in rev\n";
							echo $conn->error;
							exit();
						}

						//var_dump($f);
						echo $conn->error;

						runReversers();
					}
				}
			}
		}
		else {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
	}

	public static function dropTable($conn, $tableName, $rev = 0) {
		$setForeignKeyChecks = "set foreign_key_checks = 0";
		$drop = "drop table `$tableName`";
		$arr = objectTableMapper::getTableColumns($conn, $tableName); // for reverser
		$r = $conn->query($drop);

		if (!$r) {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
		else {
			$arr = objectTableMapper::getTableColumns($conn, $tableName);

			$reverser = function() use($conn, $tableName, $arr) {
				table::createTable($conn, $tableName, $arr, 1);
			};

			array_push($GLOBALS['reversers'], $reverser);

			if ($rev == 0) {
				echo "table dropped\n";
			}
		}
	}

	public static function renameTable($conn, $oldTableName, $newTableName, $rev = 0) {
		$sql = "rename table `{$oldTableName}` to `{$newTableName}`";
		$res = $conn->query($sql);

		if ($res) {
			$reverser = function() use($conn, $newTableName, $oldTableName) {
				table::renameTable($conn, $newTableName, $oldTableName, 1);
			};

			array_push($GLOBALS['reversers'], $reverser);

			if ($rev == 0) {
				echo "table name changed";
			}
		}
		else {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
	}
};

class column {
	public static function constructColumnStmtForAddColumn($conn, &$statment, &$key, &$value, $tableName) {
		$arr = [];
		$statment .= "`$key`";

		if ( isset($value['type']) ) {
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
		elseif ( isset($value['max']) ) {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
		else {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
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
				$arr['primary'] = $sql;
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
			$x = foreignKeyManager::checkForeignKeyExistence($conn, $tableName, $key);

			if ($x === false) { // no foreign key for this column
				$referencedTableName = $value['foreign key']['table'];
				$tableColumn = $value['foreign key']['column'];
				$alter = "alter table `$tableName` add constraint foreign key(`$key`) references `$referencedTableName`(`$tableColumn`)";
				array_push($arr, $alter);
			}
		}

		return $arr;
	}

	public static function constructColumnStmtForCreateTable($conn, &$statment, &$key, &$value, $tableName) {
		$arr = [];
		$statment .= "`$key`";

		if ( isset($value['type']) ) {
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
		elseif ( isset($value['max']) ) {
			echo "error: can't have max without determining type\n";

			if ($rev == 1) {
				echo "stuck in rev\n";
				exit();
			}

			runReversers();
		}
		else {
			echo "error: you must specify type\n";

			if ($rev == 1) {
				echo "stuck in rev\n";
				exit();
			}

			runReversers();
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
			$statment .= " primary key";
			$arr['primary'] = $key;
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

		$alter = "";
		if ( isset($value["foreign key"]) ) {
			$x = foreignKeyManager::checkForeignKeyExistence($conn, $tableName, $key);

			if ($x === false) { // no foreign key for this column
				$referencedTableName = $value['foreign key']['table'];
				$tableColumn = $value['foreign key']['column'];
				$alter = "alter table `$tableName` add constraint foreign key(`$key`) references `$referencedTableName`(`$tableColumn`)";
				array_push($arr, [$alter, $key]);
			}
		}

		return $arr;
	}

	public static function addColumn($conn, $tableName, $key, $arr, $rev = 0) {
		$alter = "alter table `$tableName` add column ";
		$arr = column::constructColumnStmtForAddColumn($conn, $alter, $key, $arr, $tableName);
		$res = $conn->query($alter);

		if (!$res) {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
		else {
			$reverser = function() use($conn, $tableName, $key) {
				column::dropColumn($conn, $tableName, $key, 1);
			};

			array_push($GLOBALS['reversers'], $reverser);

			if ($rev == 0) {
				echo "column {$key} added\n";
			}
		}
		foreach ($arr as $key => $value) {
			if ($key === 'primary') {
				$r = $conn->query($value);

				if ($r) {
					if ($rev == 0) {
						echo "primary key added\n";
					}
				}
				else {
					if ($rev == 1) {
						echo "stuck in rev\n";
						echo $conn->error;
						exit();
					}

					echo $conn->error;

					runReversers();
				}
			}
			else {
				$r = $conn->query($value);

				if ($r) {
					if ($rev == 0) {
						echo "foreign key added\n";
					}
				}
				else {
					if ($rev == 1) {
						echo "stuck in rev\n";
						echo $conn->error;
						exit();
					}

					echo $conn->error;

					runReversers();
				}
				
			}
		}
	}

	public static function dropColumn($conn, $tableName, $key, $rev = 0) {
		$arr = objectTableMapper::getTableColumns($conn, $tableName)[$key];
		foreignKeyManager::dropForeignKey($conn, $tableName, $key); // if existed
		$alter = "alter table `$tableName` drop column `$key`";
		$result = $conn->query($alter);

		if ($result) {
			$reverser = function() use($conn, $tableName, $key, $arr) {
				column::addColumn($conn, $tableName, $key, $arr, 1);
			};

			array_push($GLOBALS['reversers'], $reverser);

			if ($rev == 0) {
				echo "column {$key} deleted\n";
			}
		}
		else {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
	}

	// update every value for that column
	public static function modifyColumn($conn, $tableName, $key, $column, $rev = 0) {
		$arr = objectTableMapper::getTableColumns($conn, $tableName);
		$columnAttrs = $arr[$key];
		$alter = "alter table `$tableName` modify column `$key`";
		// some errors to handle before moving on
		// auto_increment and default
		if (key_exists('default', $column) === true && key_exists('auto_increment', $column) === true && $column['default'] === true && $column['auto_increment'] === true) {
			echo "can't add default and auto_increment at the same time\n";

			if ($rev == 1) {
				echo "stuck in rev\n";
				exit();
			}

			runReversers();
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
				if ($rev == 1) {
					echo "stuck in rev\n";
					echo $conn->error;
					exit();
				}

				echo $conn->error;

				runReversers();
			}

			if ($column['unique'] === false) {
				$res = $conn->query("alter table `$tableName` drop index `$key`");

				if (!$res) {
					echo "index not found on {$key} column\n";

					if ($rev == 1) {
						echo "stuck in rev\n";
						echo $conn->error;
						exit();
					}

					echo $conn->error;

					runReversers();
				}
				else {
					$reverser = function() use($conn, $tableName, $key) {
						$conn->query("alter table `$tableName` add index `$key`");
					};

					array_push($GLOBALS['reversers'], $reverser);
				}
			}
			elseif ($r1 !== null && $column['unique'] === true) {
				echo "unique already set on column {$key}\n";

				if ($rev == 1) {
					echo "stuck in rev\n";
					exit();
				}

				runReversers();
			}
			elseif ($r1 === null) {
				$s = "alter table `$tableName` add unique(`$key`)";
				$r = $conn->query($s);

				if (!$r) {
					if ($rev == 1) {
						echo "stuck in rev\n";
						echo $conn->error;
						exit();
					}

					echo $conn->error;

					runReversers();
				}
				else {
					$reverser = function() use($conn, $tableName, $key) {
						$conn->query("alter table `$tableName` drop index `$key`");
					};

					array_push($GLOBALS['reversers'], $reverser);
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
				echo "not null must be either true or false\n";

				if ($rev == 1) {
					echo "stuck in rev\n";
					exit();
				}

				runReversers();
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
				echo "remove auto_increment first\n";

				if ($rev == 1) {
					echo "stuck in rev\n";
					exit();
				}

				runReversers();
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
				echo "remove default first\n";

				if ($rev == 1) {
					echo "stuck in rev\n";
					exit();
				}

				runReversers();
			}
			else {
				$alter .= " auto_increment";
			}
		}

		$r = $conn->query($alter);

		if (!$r) {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
		else {
			$reverser = function() use($conn, $tableName, $key, $columnAttrs) {
				column::modifyColumn($conn, $tableName, $key, $columnAttrs, 1);
			};

			array_push($GLOBALS['reversers'], $reverser);

			if ($rev == 0) {
				echo "column {$key} modified\n";
			}
		}
	}

	public static function renameColumn($conn, $tableName, $oldColumnName, $newColumnName, $rev = 0) {
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
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
		else {
			$reverser = function() use($conn, $tableName, $newColumnName, $oldColumnName) {
				column::renameColumn($conn, $tableName, $newColumnName, $oldColumnName, 1);
			};

			array_push($GLOBALS['reversers'], $reverser);
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
					if ($rev == 1) {
						echo "stuck in rev\n";
						echo $conn->error;
						exit();
					}

					echo $conn->error;

					runReversers();
				}
			}
	}

	public static function addPrimaryKey($conn, $tableName, $key, $rev = 0) { // when update column
		$sql = "ALTER TABLE `$tableName` ADD CONSTRAINT PRIMARY KEY (`$key`);";
		$res = $conn->query($sql);

		if ($res) {
			$reverser = function() use($conn, $tableName, $key) {
				column::dropPrimaryKey($conn, $tableName, $key, 1);
			};

			array_push($GLOBALS['reversers'], $reverser);

			if ($rev == 0) {
				echo "primary key added\n";
			}
		}
		else {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
	}

	public static function dropPrimaryKey($conn, $tableName, $key = null, $rev = 0) {
		$sql = "SELECT * FROM `information_schema`.`KEY_COLUMN_USAGE` WHERE `REFERENCED_TABLE_NAME` = '$tableName' AND `REFERENCED_COLUMN_NAME` = '$key'";
		$r = mysqli_fetch_assoc( $conn->query($sql) );

		if ( !($r !== null) ) {
			$c = "alter table `$tableName` drop primary key";
			$z = $conn->query($c);

			if ($z) {
				$reverser = function() use($conn, $tableName, $key) {
					column::addPrimaryKey($conn, $tableName, $key, 1);
				};

				array_push($GLOBALS['reversers'], $reverser);

				if ($rev == 0) {
					echo "primary key droppped\n";
				}
			}
			else {
				if ($rev == 1) {
					echo "stuck in rev\n";
					echo $conn->error;
					exit();
				}

				echo $conn->error;

				runReversers();
			}
		}
		else {
			echo "primary key can't be dropped because it's referenced from another table\n";

			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			runReversers();
		}
	}
};

class foreignKeyManager {
	public static function checkForeignKeyExistence($conn, $tableName, $key) {
		$sql = "select `constraint_name` from `INFORMATION_SCHEMA`.`KEY_COLUMN_USAGE` where `column_name` = '$key' and `table_name` = '$tableName' and REFERENCED_TABLE_NAME != 'NULL'";
		$s = $conn->query($sql);		
		$r = mysqli_fetch_all($s, MYSQLI_ASSOC);

		if (count($r) > 0) {
			return $r[0]['constraint_name'];
		}

		return false;
	}

	public static function getReferencedTableAndColumn($conn, $tableName, $key) {
		$q1 = "SELECT * FROM `INFORMATION_SCHEMA`.`KEY_COLUMN_USAGE` WHERE `TABLE_NAME` = '$tableName' and `COLUMN_NAME` = '{$key}'";
		$x = $conn->query($q1);

		if ($x) {
			$y = mysqli_fetch_all($x, MYSQLI_ASSOC);
			
			if (count($y) > 0 && $y[0]['REFERENCED_TABLE_NAME'] != null) {
				return [$y[0]["REFERENCED_TABLE_NAME"], $y[0]["REFERENCED_COLUMN_NAME"], $y[0]['CONSTRAINT_NAME']];
			}
			else {
				return [];
			}
		}
		else {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
	}

	public static function addForeignKey($conn, $tableName, $column, $referencedTable, $referencedColumn, $rev = 0) {
		$sql = "ALTER TABLE `$tableName` ADD CONSTRAINT FOREIGN KEY (`$column`) REFERENCES `$referencedTable`(`$referencedColumn`);";
		$conn->query('set foreign_key_checks = 0'); // look for better way
		$res = $conn->query($sql);

		if ($res) {
			$reverser = function() use($conn, $tableName, $column) {
				foreignKeyManager::dropForeignKey($conn, $tableName, $column, 1);
			};

			array_push($GLOBALS['reversers'], $reverser);


			if ($rev == 0) {
				echo "foreign key added\n";
			}
		}
		else {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			var_dump($sql);
			echo $conn->error;

			runReversers();
		}
	}

	public static function dropForeignKey($conn, $tableName, $key, $rev = 0) {
		$foreign = foreignKeyManager::checkForeignKeyExistence($conn, $tableName, $key);

		if ($foreign) {
			$referencedTableNameAndColumnName = foreignKeyManager::getReferencedTableAndColumn($conn, $tableName, $key);
			$referencedTableName = $referencedTableNameAndColumnName[0];
			$referencedColumnName = $referencedTableNameAndColumnName[1];
			$sql = "alter table `$tableName` drop foreign key `{$foreign}`;";
			$r = $conn->query($sql);

			if ($r) {
				$reverser = function() use($conn, $tableName, $key, $referencedTableName, $referencedColumnName) {
					foreignKeyManager::addForeignKey($conn, $tableName, $key, $referencedTableName, $referencedColumnName, 1);
				};

				array_push($GLOBALS['reversers'], $reverser);

				if ($rev == 0) {
					echo "foreign key dropped\n";
				}
			}
			else {
				if ($rev == 1) {
					echo "stuck in rev\n";
					echo $conn->error;
					exit();
				}

				echo $conn->error;

				runReversers();
			}
		}
	}
};

class indexManager {
	public static function createIndex($conn, $tableName, $index, $columnToIndexTo, $rev = 0) {
		$sql = "ALTER TABLE `$tableName` ADD INDEX `$index` (`$columnToIndexTo` ASC);";
		$res = $conn->query($sql);

		if ($res) {
			$reverser = function() use($conn, $tableName, $index) {
				$conn->query("ALTER TABLE `$tableName` DROP INDEX `$index`");
			};

			array_push($GLOBALS['reversers'], $reverser);

			if ($rev == 0) {
				echo "index added\n";
			}
		}
		else {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
	}

	public static function dropIndex($conn, $tableName, $index, $rev = 0) {
		$sql = "ALTER TABLE `$tableName` DROP INDEX `$index`";
		$res = $conn->query($sql);

		if ($res) {
			$reverser = function($conn, $tableName, $index) {
				$conn->query("ALTER TABLE `$tableName` ADD INDEX `$index`");
			};

			array_push($GLOBALS['reversers'], $reverser);

			if ($rev == 0) {
				echo "index dropped\n";
			}
		}
		else {
			if ($rev == 1) {
				echo "stuck in rev\n";
				echo $conn->error;
				exit();
			}

			echo $conn->error;

			runReversers();
		}
	}
};

class objectTableMapper {
	public static function getTableColumns($conn, $tableName) {
		$result = $conn->query("SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME` = '{$tableName}' and `table_schema` = 'cafetria'");
		$arr = [];
		$flag = 0;

		while ( $row = mysqli_fetch_assoc($result) ) {
			$arr[$row['COLUMN_NAME']]['type'] = $row['DATA_TYPE'];

			if ($row['CHARACTER_MAXIMUM_LENGTH'] !== null) {
				$arr[$row['COLUMN_NAME']]['max'] = $row['CHARACTER_MAXIMUM_LENGTH'];
			}
			elseif ($row['DATA_TYPE'] == 'decimal') {
				$arr[$row['COLUMN_NAME']]['max'] = $row['NUMERIC_PRECISION'] . "," . $row['NUMERIC_SCALE'];
			}

			if ($row['IS_NULLABLE'] == "NO") {
				array_push($arr[$row['COLUMN_NAME']], "not null");
			}

			if ($row['COLUMN_KEY'] == "PRI") {
				array_push($arr[$row['COLUMN_NAME']], "primary key");
			}
			elseif ($row['COLUMN_KEY'] == "UNI") {
				array_push($arr[$row['COLUMN_NAME']], "unique");
			}

			if ($row['COLUMN_DEFAULT'] !== null) {
				$x = $row['COLUMN_DEFAULT'];
				$arr[$row['COLUMN_NAME']]['default'] = "$x";
			}

			if ($row['EXTRA'] != null) {
				$x = $row['EXTRA'];
				array_push($arr[$row['COLUMN_NAME']], $x);
			}

			$f = foreignKeyManager::getReferencedTableAndColumn($conn, $tableName, $row['COLUMN_NAME']);

			if (count($f) > 0) {
				$arr[$row['COLUMN_NAME']]['foriegn key']['table'] = $f[0];
				$arr[$row['COLUMN_NAME']]['foriegn key']['column'] = $f[1];
			}
		}
		
		return $arr;
	}
};