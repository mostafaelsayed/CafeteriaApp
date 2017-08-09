<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Gender.php';

$gender = new Gender();

function create_gender_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Gender created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_gender_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Gender deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Gender'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_gender_table($conn,$gender->drop);
}
else {
  // sql to create table
  create_gender_table($conn,$gender->create);
}


$conn->close();
?>
