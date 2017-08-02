<?php

function getByCafeteriaId($conn,$id,$backend=false) {
  if( !isset($id))
 {
 echo "Error: Id is not set";
  return;
  }
  else
  {
  $sql = "select * from category where CafeteriaId = ".$id;
  //$result = $conn->query($sql);
  if ($result = $conn->query($sql)) {
      $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $categories = json_encode($categories);
      $conn->close();
      if($backend)
      {
        return $categories;
      }
      else
      {
       echo $categories;
      }

  } else {
      echo "Error Retrieving Categories: " . $conn->error;
  }
}
}

function getCategoryById($conn,$id,$backend=false) {
  if( !isset($id))
 {
 echo "Error: Id is not set";
  return;
  }
  else
  {
  $sql = "select * from category where Id = ".$id." LIMIT 1";
  //$result = $conn->query($sql);
  if ($result = $conn->query($sql)) {
      $category = mysqli_fetch_assoc($result);
      $category = json_encode($category);
      $conn->close();
      if($backend)
      {
        return $category;
      }
      else
      {
       echo $category;
      }

  } else {
      echo "Error Retrieving Category: " . $conn->error;
  }
}
}

function addCategory($conn,$name,$CafeteriaId) {
  if( !isset($name))
 {
 echo "Error: Name is not set";
  return;
  }
// elseif (!isset($image)) {
//  echo "Error: Image is not set";
//   return;
//   }
  elseif (!isset($CafeteriaId)) {
 echo "Error: Cafeteria Id is not set";
  return;
  }
  else
  {
  $sql = "insert into category (Name,CafeteriaId) values (?,?)"; // string should be quoted like that (single quotes)
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$Name,$Id);
  $Name = $name;
  //$Image=$image;
  $Id = $CafeteriaId;
  //echo $stmt->execute();
  if ($stmt->execute()===TRUE){
    echo "Category Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
  $conn->close();
}
}



function editCategory($conn,$name,$id) {
if( !isset($name))
 {
 echo "Error: Name is not set";
  return;
  }
 //  elseif( !isset($image))
 // {
 // echo "Error: Image is not set";
 //  return;
 //  }
elseif (!isset($id)) {
 echo "Error: Id is not set";
  return;
  }
  else {
  $sql = "update category set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$Name,$Id);
  $Name = $name;
  //$Image=$image;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Category Name updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}



function deleteCategory($conn,$id) {
if (!isset($id)) {
 echo "Error: Id is not set";
  return;
  }
  else {

  $conn->query("set foreign_key_checks=0");
  $sql = "delete from category where Id = ".$id." LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Category deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}




?>
