<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Order.php';

$order = new Order();

function create_order_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Order created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_order_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Order deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Order'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_order_table($conn,$order->drop);
}
else {
  // sql to create table
  create_order_table($conn,$order->create);
}


$conn->close();
?>
