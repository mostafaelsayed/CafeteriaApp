<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Category.php';

$category = new Category();
$connection = new Connection();
$conn = $connection->check_connection();

function create_category_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Category created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_category_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Category deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Category'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_category_table($conn,$category->sql2);
}
else {
  // sql to create table
  create_category_table($conn,$category->sql1);
}


$conn->close();
?>
