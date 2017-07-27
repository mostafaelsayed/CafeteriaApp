<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\OrderStatus.php';

$orderStatus = new OrderStatus();

function create_orderStatus_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table OrderStatus created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_orderStatus_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table OrderStatus deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'OrderStatus'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_orderStatus_table($conn,$orderStatus->drop);
}
else {
  // sql to create table
  create_orderStatus_table($conn,$orderStatus->create);
}


$conn->close();
?>
