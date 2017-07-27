<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Times.php';

$times = new Times();

function create_times_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Times created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_times_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Times deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}


$r = $conn->query("SHOW TABLES LIKE 'Times'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_times_table($conn,$times->drop);
}
else {
  // sql to create table
  create_times_table($conn,$times->create);
}


$conn->close();
?>
