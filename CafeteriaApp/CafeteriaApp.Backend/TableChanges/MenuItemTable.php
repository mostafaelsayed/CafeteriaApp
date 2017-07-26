<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\MenuItem.php';

$menuItem = new menuItem();

function create_menuItem_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table MenuItem created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_menuItem_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table MenuItem deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'MenuItem'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_menuItem_table($conn,$menuItem->sql2);
}
else {
  // sql to create table
  create_menuItem_table($conn,$menuItem->sql1);
}


$conn->close();
?>
