<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\PaymentMethod.php';

$paymentMethod = new PaymentMethod();

function create_paymentMethod_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table PaymentMethod created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_paymentMethod_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table PaymentMethod deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'PaymentMethod'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_paymentMethod_table($conn,$paymentMethod->drop);
}
else {
  // sql to create table
  create_paymentMethod_table($conn,$paymentMethod->create);
}


$conn->close();
?>
