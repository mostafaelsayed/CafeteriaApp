<?php

include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Cafeteria.php';

$cafeteria = new Cafeteria();

function create_cafeteria_table($con,$sql)
{
  if ($con->query($sql) === TRUE) {
      echo "Table Cafeteria created successfully";
  } else {
      echo "Error creating table: " . $con->error;
  }
}

function delete_cafeteria_table($con,$sql) {
  if ($con->query($sql) === TRUE) {
      echo "Table Cafeteria deleted successfully";
  } else {
      echo "Error deleting table: " . $con->error;
  }
}

function alter_cafeteria_table($con,$sql) {
  if ($con->query($sql) === TRUE) {
      echo "Table Cafeteria updated successfully";
  } else {
      echo "Error updating table: " . $con->error;
  }
}





$r = $conn->query("SHOW TABLES LIKE 'Cafeteria'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_cafeteria_table($conn,$cafeteria->drop);
}
else {
  // sql to create table
  create_cafeteria_table($conn,$cafeteria->create);
}

$conn->close();
?>
