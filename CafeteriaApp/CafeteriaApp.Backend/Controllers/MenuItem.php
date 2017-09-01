<?php

require_once('CafeteriaApp.Backend/ImageHandle.php');

function getMenuItemByCategoryId($conn,$id,$customer = false)//????????????????
{
  if (!isset($id))
  {
   // echo "Error:Category Id is not set";
    return;
  }
  else
  {
    $sql = "select * from MenuItem where CategoryId = ".$id;
    if ($customer)
    {
      $sql.=" and Visible = 1 ";
    }
    if ($result = $conn->query($sql))
    {
      $MenuItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      return $MenuItems;
    }
    else
    {
      echo "Error retrieving MenuItems: " . $conn->error;
    }
  }
}

function getMenuItemById($conn , $id)
{
  if (!isset($id))
  {
    //echo "Error:MenuItem Id is not set";
    return;
  }
  else
  {
    $sql = "select * from MenuItem where Id = ".$id." LIMIT 1";
    if ($result = $conn->query($sql))
    {
      $MenuItem = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $MenuItem;
    }
    else
    {
      echo "Error retrieving MenuItem: " . $conn->error;
    }
  }
}

function getMenuItemsByIds($conn , $ids)
{
  if (!isset($ids))
  {
    //echo "Error:MenuItem Id is not set";
    return;
  }
  else
  {
    $sql = "select * from MenuItem where Id in (". implode(',', $ids) . ")";
    if ($result = $conn->query($sql))
    {
      $MenuItem = mysqli_fetch_all($result,MYSQLI_ASSOC);
      mysqli_free_result($result);
      return $MenuItem;
    }
    else
    {
      echo "Error retrieving MenuItem: " . $conn->error;
    }
  }
}

function getMenuItemPriceById($conn , $id)
{
  if (!isset($id))
  {
    //echo "Error:MenuItem Id is not set";
    return;
  }
  else
  {
    $sql = "select Price from MenuItem where Id = ".$id." LIMIT 1";
    if ($result = $conn->query($sql))
    {
      $MenuItem = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $MenuItem["Price"];
    }
    else
    {
      echo "Error retrieving MenuItem: " . $conn->error;
    }
  }
}

function addMenuItem($conn,$name,$price,$description,$categoryId,$imageData = null)
{
  if (!isset($name))
  {
    //echo "Error: MenuItem name is not set";
    return;
  }
  elseif (!isset($price))
  {
   // echo "Error: MenuItem price is not set";
    return;
  }
  elseif (!isset($description))
  {
   // echo "Error: MenuItem description is not set";
    return;
  }
  elseif (!isset($categoryId))
  {
    //echo "Error: Category Id is not set";
    return;
  }
  else
  {
    if ($imageData != null)
    {
      $imageFileName = addImageFile($imageData);
      $sql = "insert into menuitem (Name,Price,Description,CategoryId,Image) values (?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdsis",$Name,$Price,$Description,$CategoryId,$Image);
      $Name = $name;
      $Price = $price;
      $Description = $description;
      $CategoryId = $categoryId;
      $Image = $imageFileName;
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
      return "MenuItem Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function editMenuItem($conn,$name,$price,$description,$id,$imageData,$visible)
{
  if (!isset($name))
  {
    //echo "Error: MenuItem name is not set";
    return;
  }
  elseif (!isset($price))
  {
    //echo "Error: MenuItem price is not set";
    return;
  }
  elseif (!isset($description))
  {
    //echo "Error: MenuItem description is not set";
    return;
  }
  elseif (!isset($id))
  {
    //echo "Error: MenuItem id is not set";
    return;
  }
  else
  {
    $result = $conn->query("select Image from menuitem where Id = ".$id);
    $menuItem = (mysqli_fetch_assoc($result));
    mysqli_free_result($result);
    if ($imageData != null && $imageData != $menuItem['Image'])
    {
      $imageFileName = editImage($imageData,$menuItem['Image']);
      $sql = "update MenuItem set Name = (?) , Price = (?) , Description = (?) , Image = (?) where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdssi",$Name,$Price,$Description,$Image,$Id);
      $Name = $name;
      $Price = $price;
      $Description = $description;
      $Id = $id;
      $Image = $imageFileName;
    }
    else
    {
      $sql = "update MenuItem set Name = (?) , Price = (?) , Description = (?) , Visible = (?) where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdsii",$Name,$Price,$Description,$Visible,$Id);
      $Name = $name;
      $Price = $price;
      $Description = $description;
      $Id = $id;
      $Visible = $visible;
    }

    if ($stmt->execute()===TRUE)
    {
      return "MenuItem updated successfully";
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
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    $sql = "select Image from MenuItem where Id = ".$id." LIMIT 1";
    $result = $conn->query($sql);
    deleteImageFileIfExists(mysqli_fetch_assoc($result)['Image']);
    mysqli_free_result($result);
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from MenuItem where Id = ".$id. " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "MenuItem deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>