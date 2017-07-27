<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\User.php';

$user = new User();

function create_user_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table User created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_user_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table User deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'User'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_user_table($conn,$user->drop);
}
else {
  // sql to create table
  create_user_table($conn,$user->create);
}


$conn->close();
?>
