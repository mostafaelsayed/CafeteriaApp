<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Dates.php';

$date = new Dates();

function create_date_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Dates created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_date_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Dates deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Dates'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_date_table($conn,$date->drop);
}
else {
  // sql to create table
  create_date_table($conn,$date->create);
}


$conn->close();
?>
