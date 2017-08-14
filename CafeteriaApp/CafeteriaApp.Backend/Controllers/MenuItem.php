<?php

function getMenuItemByCategoryId($conn,$id,$customer=false)//????????????????
{
  if (!isset($id))
  {
   // echo "Error:Category Id is not set";
    return;
  }
  else
  {
    $sql = "select * from MenuItem where CategoryId = ".$id;
    if($customer)
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
      return "MenuItem Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function editMenuItem($conn,$name,$price,$description,$id,$imageData)
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
    $menuItemImage = basename($menuItem['Image']);
    global $newImageName;
    if ($imageData != null && $imageData != $menuItem['Image'])
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
      return "MenuItem updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
    mysqli_free_result($result);//???????????????????????????????????????????????
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
    $resultImage = basename(mysqli_fetch_assoc($result)['Image']);
    mysqli_free_result($result);
    chdir("../uploads");
    if (file_exists($resultImage)) {
      unlink($resultImage);
    }
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