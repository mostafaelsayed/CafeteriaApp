<?php

function getMenuItemByCategoryId($conn , $id,$backend=false)
{
  if (!isset($id))
  {
    echo "Error:Category Id is not set";
    return;
  }
  else
  {
    $sql = "select * from MenuItem where CategoryId = ".$id;
    if ($result = $conn->query($sql))
    {
      $MenuItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $MenuItems = json_encode($MenuItems);
      if ($backend)
      {
        return $MenuItems;
      }
      else
      {
       echo $MenuItems;
      }
    } 
    else
    {
      echo "Error retrieving MenuItems: " . $conn->error;
    }
  }
}

function getMenuItemById($conn , $id,$backend=false)
{
  if( !isset($id))
  {
    echo "Error:MenuItem Id is not set";
    return;
  }
  else
  {
    $sql = "select * from MenuItem where Id = ".$id." LIMIT 1";
    if ($result = $conn->query($sql))
    {
      $MenuItem = mysqli_fetch_assoc($result);
      $MenuItem = json_encode($MenuItem);
       if($backend)
      {
        return $MenuItem;
      }
      else
      {
       echo $MenuItem;
      }
    } 
    else
    {
      echo "Error retrieving MenuItem: " . $conn->error;
    }
  }
}

function getMenuItemPriceById($conn , $id)
{
  if( !isset($id))
  {
    echo "Error:MenuItem Id is not set";
    return;
  }
  else
  {
    $sql = "select Price from MenuItem where Id = ".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result = $conn->query($sql))
    {
      $MenuItem = mysqli_fetch_assoc($result);
      return $MenuItem["Price"];
    }
    else
    {
      echo "Error retrieving MenuItem: " . $conn->error;
    }
  }
}

function addMenuItem($conn,$name,$price,$description,$categoryId,$imageData)
{
  if( !isset($name))
  {
    echo "Error: MenuItem name is not set";
    return;
  }
  elseif (!isset($price))
  {
    echo "Error: MenuItem price is not set";
    return;
  }
  elseif (!isset($description))
  {
    echo "Error: MenuItem description is not set";
    return;
  }
  elseif (!isset($categoryId))
  {
    echo "Error: Category Id is not set";
    return;
  }
  else
  {
    if ($imageData != null)
    {
      $sql = "insert into menuitem (Name,Price,Description,CategoryId,Image) values (?,?,?,?,?)";
      chdir("../uploads"); // go to uploads directory
      $newImageName = str_replace(':',' ',(string)date("Y-m-d H:i:s")).".jpg";
      $ifp = fopen($newImageName,"x+");
      fwrite($ifp,base64_decode($imageData));
      fclose($ifp);
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdsis",$Name,$Price,$Description,$CategoryId,$Image);
      $Name = $name;
      $Price = $price;
      $Description = $description;
      $CategoryId = $categoryId;
      $Image = "/CafeteriaApp.Backend/uploads/".$newImageName;
    }
    else
    {
      $sql = "insert into menuitem (Name,Price,Description,CategoryId) values (?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdsi",$Name,$Price,$Description,$CategoryId);
      $Name = $name;
      $Price = $price;
      $Description = $description;
      $CategoryId = $categoryId;
    }

    if ($stmt->execute()===TRUE)
    {
      echo "MenuItem Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function editMenuItem($conn,$name,$price,$description,$id,$imageData)
{
  if( !isset($name))
  {
    echo "Error: MenuItem name is not set";
    return;
  }
  elseif (!isset($price))
  {
    echo "Error: MenuItem price is not set";
    return;
  }
  elseif (!isset($description))
  {
    echo "Error: MenuItem description is not set";
    return;
  }
  elseif (!isset($id))
  {
    echo "Error: MenuItem id is not set";
    return;
  }
  else
  {
    $menuItem = (mysqli_fetch_assoc($conn->query("select Image from menuitem where Id = ".$id)));
    $menuItemImage = basename($menuItem['Image']);
    global $newImageName;
    if ($imageData != null)
    {
      $sql = "update MenuItem set Name = (?) , Price = (?) , Description = (?) , Image = (?) where Id = (?)";
      chdir("../uploads"); // go to uploads directory
      if ($menuItemImage != null)
      {
        unlink($menuItemImage);
      }
      $newImageName = str_replace(':',' ',(string)date("Y-m-d H:i:s")).".jpg";
      $ifp = fopen($newImageName,"x+");
      fwrite($ifp,base64_decode($imageData));
      fclose($ifp);
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdssi",$Name,$Price,$Description,$Image,$Id);
      $Name = $name;
      $Price = $price;
      $Description = $description;
      $Id = $id;
      $Image = "/CafeteriaApp.Backend/uploads/".$newImageName;
    }
    else
    {
      $sql = "update MenuItem set Name = (?) , Price = (?) , Description = (?) where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdsi",$Name,$Price,$Description,$Id);
      $Name = $name;
      $Price = $price;
      $Description = $description;
      $Id = $id;
    }

    if ($stmt->execute()===TRUE)
    {
      echo "MenuItem updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function deleteMenuItem($conn,$id)
{
 if (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from MenuItem where Id = ".$id. " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      echo "MenuItem deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}


?>
