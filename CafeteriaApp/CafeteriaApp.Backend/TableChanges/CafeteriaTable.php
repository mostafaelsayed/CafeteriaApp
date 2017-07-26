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





if (property_exists('Cafeteria','createTable')) {
  // sql to create table
  create_cafeteria_table($conn,$cafeteria->createTable);
}
else if (property_exists('Cafeteria','deleteTable')){
$conn->query("set foreign_key_checks=0");
delete_cafeteria_table($conn,$cafeteria->deleteTable);
}
else if (property_exists('Cafeteria','alterCafeteriaTable')) {
  $conn->query("set foreign_key_checks=0");
  alter_cafeteria_table($conn,$cafeteria->alterCafeteriaTable);
  alter_cafeteria_table($conn,$cafeteria->alterCategoryTable);

}
$conn->close();
?>
