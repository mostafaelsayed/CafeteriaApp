<?php
include('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend\connection.php');

// cafeteria table
// $sql1 = "insert into cafeteria (Name) values (?)";
// $stmt1 = $conn->prepare($sql1);
// $stmt1->bind_param("s",$name);
// $name = "cafeteria 1";
// $stmt1->execute();
// $name = "cafeteria 2";
// $stmt1->execute();
// category table
//$stmt1->close();

$conn->query("set foreign_key_checks=0");
$sql2 = "insert into category (Name,CafeteriaId) values (?,?)";
$stmt2 = $conn->prepare($sql2);
//echo 'prepare error: ', $conn->error, PHP_EOL;
$stmt2->bind_param("si",$name,$cafeteriaid);
//echo 'prepare error: ', $conn->error, PHP_EOL;
$name = "category 3";
$cafeteriaid = 1;
$stmt2->execute();
// echo 'prepare error: ', $conn->error, PHP_EOL;
//$conn->commit();
$name = "category 4";
$cafeteriaid = 1;
$stmt2->execute();
//echo 'prepare error: ', $conn->error, PHP_EOL;
//$conn->commit();
$stmt2->close();
//echo 'prepare error: ', $conn->error, PHP_EOL;
$conn->close();
 ?>
