<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Customer.php';

$customer = new Customer();

function create_customer_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Customer created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_customer_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Customer deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Customer'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_customer_table($conn,$customer->drop);
}
else {
  // sql to create table
  create_customer_table($conn,$customer->create);
}


$conn->close();
?>
