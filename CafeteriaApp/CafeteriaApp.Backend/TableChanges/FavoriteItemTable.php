<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\FavoriteItem.php';

$favoriteItem = new FavoriteItem();

function create_favoriteItem_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table FavoriteItem created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_favoriteItem_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table FavoriteItem deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'FavoriteItem'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_favoriteItem_table($conn,$favoriteItem->drop);
}
else {
  // sql to create table
  create_favoriteItem_table($conn,$favoriteItem->create);
}


$conn->close();
?>
