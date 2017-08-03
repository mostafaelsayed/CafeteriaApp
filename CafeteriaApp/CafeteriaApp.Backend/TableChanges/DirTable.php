<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Dir.php';

$dir = new Dir();

function create_dir_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Dir created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_dir_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Dir deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Dir'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_dir_table($conn,$dir->drop);
}
else {
  // sql to create table
  create_dir_table($conn,$dir->create);
}


$conn->close();
?>
