<?php

function getCafeterias($conn)
{
  $sql = "select * from Cafeteria";
  if ($result = $conn->query($sql))
  {
    $cafeterias = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
    mysqli_free_result($result);
      return $cafeterias;
    
  }
  else
  {
    echo "Error retrieving Cafeterias : " . $conn->error;
  }
}


function getCafeteriaById($conn ,$id)
{if (!isset($id)) 
  {
    return;
  }
  else
  {
  $sql = "select * from Cafeteria where Id =".$id." LIMIT 1";
  if ($result = $conn->query($sql))
  {
    $cafeteria = mysqli_fetch_assoc($result); // fetch only the first row of the result
    mysqli_free_result($result);
    if ($backend)
    {
      return $cafeteria;
    }
    else
    {   
     $cafeteria = json_encode($cafeteria); // ??

      echo $cafeteria;
    }   
  }
  else
  {
    echo "Error retrieving Cafeteria : " . $conn->error;
  }
}
}

function addCafeteria($conn,$name,$imageData = null) // if image null ?????? 
{
  if (!isset($name)) //deal with the hacker
  {
    //echo "Error: Name is not set";
    return;
  }

  else
  {
    if ($imageData != null)
    {
      $sql = "insert into cafeteria (Name,Image) values (?,?)";
      chdir("../uploads"); // go to uploads directory
      $newImageName = str_replace(':',' ',(string)date("Y-m-d H:i:s")).".jpg";
      $ifp = fopen($newImageName,"x+");
      fwrite($ifp,base64_decode($imageData));
      fclose($ifp);
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss",$Name,$Image);
      $Name = $name;
      $Image = "/CafeteriaApp.Backend/uploads/".$newImageName;
    }
    else
    {
      $sql = "insert into cafeteria (Name) values (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s",$Name);
      $Name = $name;
    }

    if ($stmt->execute()===TRUE)
    {
      return "Cafeteria Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function editCafeteria($conn,$name,$id,$imageData = null)
{
  if(!isset($name) || !isset($id))
  {
   // echo "Error: Name is not set";
    return;
  }
  else
  {
    $result = $conn->query("select Image from cafeteria where Id = ".$id);
    $cafeteria = (mysqli_fetch_assoc($result));
    mysqli_free_result($result);
    if ($imageData != null && $imageData != $cafeteria['Image'])
    {
      $cafeteriaImage = basename($cafeteria['Image']);    
      $sql = "update cafeteria set Name = (?) , Image = (?) where Id = (?)";
      chdir("../uploads"); // go to uploads directory
      if ($cafeteriaImage != null && file_exists($cafeteriaImage))
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
      return "Cafeteria updated successfully";
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
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    $sql = "select Image from cafeteria where Id = ".$id." LIMIT 1";
    $result = $conn->query($sql);
    $resultImage = basename(mysqli_fetch_assoc($result)['Image']);
    mysqli_free_result($result);
    chdir("../uploads");
    if (file_exists($resultImage))
    {
      unlink($resultImage);
    }
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from cafeteria where Id = ".$id." LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "Cafeteria deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>
