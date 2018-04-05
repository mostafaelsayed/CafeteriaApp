<?php
  function getFavoriteItemsByUserId($conn, $Cid) {
    $sql = "select favoriteitem.Id, menuitem.Name, menuitem.Description, menuitem.Price, menuitem.Image, favoriteitem.MenuItemId from favoriteitem INNER JOIN menuitem ON favoriteitem.MenuItemId = menuitem.Id where UserId = " . $Cid;
    $result = $conn->query($sql);

    if ($result) {
      $favoriteItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      return $favoriteItems;
    }
    else {
      echo "Error retrieving FavoriteItems: ", $conn->error;
    }
  }

  function getFavoriteItemById($conn, $id) {
    $sql = "select * from favoriteitem where Id = " . $id . " LIMIT 1";
    $result = $conn->query($sql);

    if ($result) {
      $favoriteItems = mysqli_fetch_assoc($result);
      mysqli_free_result($result); 
      return $favoriteItems;
    }
    else {
      echo "Error retrieving FavoriteItem: ", $conn->error;
    }
  }

  function checkExisitingFavoriteItem($conn, $Cid, $Mid) {
    $sql = "select count(*) from favoriteitem where UserId = " . $Cid . " and MenuItemId = " . $Mid;
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result, MYSQLI_NUM); 
    $result = (int)$result[0];

    if ($result > 0) {
      return true; // exist
    }
    else {
      return false;//not exist
    }

    if ( isset($conn->error) ) {
      echo "Error retrieving FavoriteItem: ", $conn->error;
    }
  }

  function addFavoriteItem($conn, $Cid, $Mid) {
    if ( checkExisitingFavoriteItem($conn, $Cid, $Mid) ) {
      return;
    }
    else {
      $sql = "insert into favoriteitem (UserId,MenuItemId) values (?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ii", $Cid, $Mid);

      if ($stmt->execute() === TRUE) {
        return "FavoriteItem Added successfully";
      }
      else {
        echo "Error: ", $conn->error;
      }
    }
  }

  function deleteFavoriteItem($conn, $id) {
    //$conn->query("set foreign_key_checks=0");
    $sql = "delete from favoriteitem where Id = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "FavoriteItem deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteFavoriteItemByMenuItemId($conn, $Cid, $Mid) {
    if ( !isset($Cid) || !isset($Mid) ) {
      //echo "Error: Id is not set";
      return;
    }
    else {

      //$conn->query("set foreign_key_checks=0");
      $sql = "delete from favoriteitem where MenuItemId = " . $Mid . " and UserId = " . $Cid . " LIMIT 1";

      if ($conn->query($sql) === TRUE) {
        return '0';
      }
      else {
        echo "Error: ", $conn->error;
      }
    }
  }
?>