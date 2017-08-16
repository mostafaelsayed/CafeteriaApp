<?php

function getFavoriteItemsByCustomerId($conn,$Cid)
{
  if (!isset($Cid)) 
  {
    //echo "Error: Customer Id is not set";
    return;
  }
  else
  {
    $sql = "select FavoriteItem.Id , MenuItem.Name , MenuItem.Description , MenuItem.Price ,MenuItem.Image , FavoriteItem.MenuItemId from FavoriteItem INNER JOIN MenuItem ON FavoriteItem.MenuItemId = MenuItem.Id where CustomerId =".$Cid;
    $result = $conn->query($sql);
    if ($result)
    {
      $favoriteItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
        return $favoriteItems;   
   
    }
    else
    {
      echo "Error retrieving FavoriteItems: " . $conn->error;
    }
  }
}

function getFavoriteItemById($conn,$id)
{
  if (!isset($id)) 
  {
    //echo "Error: FavoriteItem Id is not set";
    return;
  }
  else
  {
    $sql = "select * from FavoriteItem where Id =".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $favoriteItems = mysqli_fetch_assoc($result);
      mysqli_free_result($result); 
        return $favoriteItems;   
      
    }
    else
    {
      echo "Error retrieving FavoriteItem: " . $conn->error;
    }
  }
}

function checkExisitingFavoriteItem($conn,$Cid,$Mid)
{
  if (!isset($Cid)|| !isset($Mid)) 
  {
    //echo "Error: FavoriteItem Id is not set";
    return;
  }
  else
  {
    $sql = "select count(*) from FavoriteItem where CustomerId =".$Cid." and MenuItemId =".$Mid;
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result, MYSQLI_NUM); 
    if ($result[0]>0) 
    { 
      return true; // exist
    }
    else
    {
      return false;//not exist
    }
    
    if (isset($conn->error)) 
    {
      echo "Error retrieving FavoriteItem: " . $conn->error;
    }
  }
}

function addFavoriteItem($conn,$Cid,$Mid)
{ if(checkExisitingFavoriteItem($conn,$Cid,$Mid))
  {
    return;
  }
  elseif (!isset($Cid))
  {
    //echo "Error: Customer Id is not set";
    return;
  }
  elseif (!isset($Mid))
  {
   // echo "Error: MenuItem Id is not set";
    return;
  }
  else
  {
    $sql = "insert into FavoriteItem (CustomerId,MenuItemId) values (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii",$CustomerId,$MenuItemId);
    $CustomerId = $Cid;
    $MenuItemId=$Mid;
    if ($stmt->execute()===TRUE)
    {
      return "FavoriteItem Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function deleteFavoriteItem($conn,$id)
{
  if (!isset($id))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks=0");
    $sql = "delete from FavoriteItem where Id = ".$id. " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "FavoriteItem deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function deleteFavoriteItemByMenuItemId($conn,$Cid,$Mid)
{
  if (!isset($Cid) || !isset($Mid))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks=0");
    $sql = "delete from FavoriteItem where MenuItemId = ".$Mid. " and  CustomerId=".$Cid." LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "FavoriteItem deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

// function editFavoriteItem($conn,$n,$Id)
// {
//   $sql = "update FavoriteItem set Name = (?) where Id = (?)";
//   $stmt = $conn->prepare($sql);
//   $stmt->bind_param("si",$name,$id);
//   $name = $n;
//   $id = $Id;
//   //$conn->query($sql);
//   if ($stmt->execute()===TRUE)
//   {
//     echo "FavoriteItem updated successfully";
//   }
//   else
//   {
//     echo "Error: ".$conn->error;
//   }
// }

 ?>
