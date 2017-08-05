<?php
//require_once("CafeteriaApp.Backend/connection.php");

function getByCafeteriaId($conn,$id,$backend=false)
{
  if (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    $sql = "select * from category where CafeteriaId = ".$id;
    if ($result = $conn->query($sql))
    {
      $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $categories = json_encode($categories);
      if ($backend)
      {
        return $categories;
      }
      else
      {
        echo $categories;
      }
    }
    else
    {
      echo "Error Retrieving Categories: " . $conn->error;
    }
  }
}

function getCategoryById($conn,$id,$backend=false)
{
  if( !isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    $sql = "select * from category where Id = ".$id." LIMIT 1";
    if ($result = $conn->query($sql))
    {
      $category = mysqli_fetch_assoc($result);
      $category = json_encode($category);
      if ($backend)
      {
        return $category;
      }
      else
      {
       echo $category;
      }
    }
    else
    {
      echo "Error Retrieving Category: " . $conn->error;
    }
  }
}

function addCategory($conn,$name,$cafeteriaId,$imageData)
{
  if (!isset($name))
  {
    echo "Error: Name is not set";
    return;
  }
  elseif (!isset($cafeteriaId))
  {
    echo "Error: Cafeteria Id is not set";
    return;
  }

  else
  {
    if ($imageData != null)
    {
      //echo "ay 7aga";
      $sql = "insert into category (Name,Image,CafeteriaId) values (?,?,?)";
      chdir("../uploads"); // go to uploads directory
      $newImageName = str_replace(':',' ',(string)date("Y-m-d H:i:s")).".jpg";
      $ifp = fopen($newImageName,"x+");
      fwrite($ifp,base64_decode($imageData));
      fclose($ifp);
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssi",$Name,$Image,$Id);
      $Name = $name;
      $Id = $cafeteriaId;
      $Image = "/CafeteriaApp.Backend/uploads/".$newImageName;
    }
    else
    {
      $sql = "insert into category (Name,CafeteriaId) values (?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si",$Name,$Id);
      $Name = $name;
      $Id = $cafeteriaId;
    }

    if ($stmt->execute()===TRUE)
    {
      echo "Category Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

//addCategory($conn,'scscscc',2,null);

function editCategory($conn,$name,$id,$imageData = null)
{
  if (!isset($name))
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
    $category = (mysqli_fetch_assoc($conn->query("select Image from category where Id = ".$id)));
    $categoryImage = basename($category['Image']);
    global $newImageName;
    if ($imageData != null)
    {
      $sql = "update category set Name = (?) , Image = (?) where Id = (?)";
      chdir("../uploads"); // go to uploads directory
      if ($categoryImage != null)
      {
        unlink($categoryImage);
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
      $sql = "update category set Name = (?) where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si",$Name,$Id);
      $Name = $name;
      $Id = $id;
    }

    if ($stmt->execute()===TRUE)
    {
      echo "Category updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function deleteCategory($conn,$id)
{
  if (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    $conn->query("set foreign_key_checks=0");
    $sql = "delete from category where Id = ".$id." LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      echo "Category deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

//require_once("CafeteriaApp.Backend/footer.php");

?>
