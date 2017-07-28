<?php
include 'CafeteriaApp.Backend\connection.php';
include 'CafeteriaApp.Backend\Models\Comment.php';

$comment = new Comment();

function create_comment_table($conn,$sql)
{
  if ($conn->query($sql) === TRUE) {
      echo "Table Comment created successfully";
  } else {
      echo "Error creating table: " . $conn->error;
  }
}

function delete_comment_table($conn,$sql) {
  if ($conn->query($sql) === TRUE) {
      echo "Table Comment deleted successfully";
  } else {
      echo "Error deleting table: " . $conn->error;
  }
}

// sql to create table
// sql to drop table
// delete_category_table($conn,$category->sql2);
$r = $conn->query("SHOW TABLES LIKE 'Comment'");
if ($r && $r->num_rows != 0) {
  // sql to drop table
  //$conn->query("set foreign_key_checks=0");
  delete_comment_table($conn,$comment->drop);
}
else {
  // sql to create table
  create_comment_table($conn,$comment->create);
}


$conn->close();
?>
