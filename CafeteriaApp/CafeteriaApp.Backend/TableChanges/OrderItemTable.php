<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\OrderItem.php';

$orderItem = new OrderItem();

function create_orderItem_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table OrderItem created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_orderItem_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table OrderItem deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'OrderItem'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_orderItem_table($conn,$orderItem->drop);
}
else {
  // sql to create table
  create_orderItem_table($conn,$orderItem->create);
}


$conn->close();
?>
