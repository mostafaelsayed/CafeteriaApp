<?php

function getCafeterias($conn,$backend=false)
{
  $sql = "select * from Cafeteria";
  if ($result = $conn->query($sql))
  {
    $cafeterias = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
    $cafeterias = json_encode($cafeterias); // ??
    if ($backend)
    {
      return $cafeterias;
    }
    else
    {
     echo $cafeterias;
    }
  }
  else
  {
    echo "Error retrieving Cafeterias : " . $conn->error;
  }
}

function getCafeteriaById($conn ,$id,$backend=false)
{
  $sql = "select * from Cafeteria where Id =".$id." LIMIT 1";
  if ($result = $conn->query($sql))
  {
    $cafeteria = mysqli_fetch_assoc($result); // fetch only the first row of the result
    $cafeteria = json_encode($cafeteria); // ??
    if ($backend)
    {
      return $cafeteria;
    }
    else
    {
     echo $cafeteria;
    }
  }
  else
  {
    echo "Error retrieving Cafeteria : " . $conn->error;
  }
}

function addCafeteria($conn,$name,$image)
{
  if (!isset($name))
  {
    echo "Error: Name is not set";
    return;
  }

  else
  {
    $sql = "insert into cafeteria (Name,Image) values (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$name,$Image);
    $name = $name;
    $Image= $image;
    if ($stmt->execute()===TRUE)
    {
      echo "Cafeteria Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function editCafeteria($conn,$name,$id,$imageData = null)
{
  if(!isset($name))
  {
    echo "Error: Name is not set";
    return;
  }
  elseif (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    $cafeteria = (mysqli_fetch_assoc($conn->query("select Image from cafeteria where Id = ".$id)));
    $cafeteriaImage = basename($cafeteria['Image']);
    global $newImageName;
    if ($imageData != null)
    {
      $sql = "update cafeteria set Name = (?) , Image = (?) where Id = (?)";
      chdir("../uploads"); // go to uploads directory
      if ($cafeteriaImage != null)
      {
        unlink($cafeteriaImage);
      }
      $newImageName = str_replace(':',' ',(string)date("Y-m-d H:i:s")).".jpg";
      $ifp = fopen($newImageName,"x+");
      fwrite($ifp,base64_decode($imageData));
      fclose($ifp);
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssi",$Name,$Image,$Id);
      $Name = $name;
      $Id = $id;
      $Image = "/CafeteriaApp.Backend/uploads/".$newImageName;
    }
    else
    {
      $sql = "update cafeteria set Name = (?) where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si",$Name,$Id);
      $Name = $name;
      $Id = $id;
    }

    if ($stmt->execute()===TRUE)
    {
      echo "Cafeteria updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function deleteCafeteria($conn,$id)
{
  if (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    $conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from cafeteria where Id = ".$id." LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      echo "Cafeteria deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>
