<?php

function getCafeterias($conn,$backend=false) {

  $sql = "select * from Cafeteria";
  //$result = $conn->query($sql);
  if ($result = $conn->query($sql)) {
      $cafeterias = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
      $cafeterias = json_encode($cafeterias); // ??
      $conn->close();
       if($backend)
      {
        return $cafeterias;
      }
      else
      {
       echo $cafeterias;
      }

  } else {
      echo "Error retrieving Cafeterias : " . $conn->error;
  }

}


function getCafeteriaById($conn ,$id,$backend=false) {

  $sql = "select * from Cafeteria where Id =".$id." LIMIT 1";
  //$result = $conn->query($sql);

  if ($result = $conn->query($sql)) {
      $cafeteria = mysqli_fetch_assoc($result); // fetch only the first row of the result
      $cafeteria = json_encode($cafeteria); // ??
      $conn->close();
       if($backend)
      {
        return $cafeteria;
      }
      else
      {
       echo $cafeteria;
      }

  } else {
      echo "Error retrieving Cafeteria : " . $conn->error;
  }

}


function addCafeteria($conn,$name,$image) {

  if( !isset($name)) {
    echo "Error: Name is not set";
    return;
  }

  else {
    // global $uploadedFile;
    // if (isset($_FILES['imageToUpload'])) {
    //   //echo "string";
    //   $uploadDir = 'CafeteriaApp.Backend/uploads/';
    //   $uploadedFile = $uploadDir.basename($_FILES['imageToUpload']['name']);
    //   if (move_uploaded_file($_FILES['imageToUpload']['tmp_name'],$uploadedFile)) {
    //     echo "File is successfully uploaded";
    //   }
    //   else {
    //     echo "Error: ".$conn->error;
    //   }
    // }
    // else {
    //   $uploadedFile = null;
    // }
    $sql = "insert into cafeteria (Name,Image) values (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$name,$Image);
    $name = $name;
    $Image= $image;
    //$conn->query($sql);
    if ($stmt->execute()===TRUE) {
      echo "Cafeteria Added successfully";
      //return mysqli_insert_id($conn);
    }
    else {
      echo "Error: ".$conn->error;
    }
  }
}


function editCafeteria($conn,$name,$id) {
  if( !isset($name))
 {
 echo "Error: Name is not set";
 return;
  }
 //   elseif( !isset($image))
 //  {
 // echo "Error: Image is not set";
 // return;
 //  }
elseif (!isset($id)) {
 echo "Error: Id is not set";
  return;
  }
  else
  {
  $sql = "update cafeteria set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$Name,$Id);
  $Name = $name;
  //$Image = $image;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Cafeteria updated successfully";
  }
  else {
    echo "Error: ".$conn->error;

  }
}
}


function deleteCafeteria($conn,$id) {
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  $conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from cafeteria where Id = ".$id." LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Cafeteria deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}



 ?>
