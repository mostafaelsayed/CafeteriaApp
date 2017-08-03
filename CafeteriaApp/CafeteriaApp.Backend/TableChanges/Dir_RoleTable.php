<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Dir_Role.php';

$dir_role = new Dir_Role();

function create_dir_role_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Dir_Role created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_dir_role_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Dir_Role deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Dir_Role'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_dir_role_table($conn,$dir_role->drop);
}
else {
  // sql to create table
  create_dir_role_table($conn,$dir_role->create);
}


$conn->close();
?>
