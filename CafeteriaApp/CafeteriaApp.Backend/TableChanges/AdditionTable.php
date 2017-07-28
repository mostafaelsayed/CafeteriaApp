<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Addition.php';

$addition = new Addition();

function create_addition_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Addition created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_addition_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Addition deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Addition'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_addition_table($conn,$addition->drop);
}
else {
  // sql to create table
  create_addition_table($conn,$addition->create);
}


$conn->close();
?>
