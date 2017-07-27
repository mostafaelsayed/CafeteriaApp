<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Role.php';

$role = new Role();

function create_role_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Role created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_role_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Role deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Role'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_role_table($conn,$role->drop);
}
else {
  // sql to create table
  create_role_table($conn,$role->create);
}


$conn->close();
?>
