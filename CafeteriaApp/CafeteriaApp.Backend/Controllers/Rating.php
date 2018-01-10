<?php
  function getMenuItemsIdsThatHaveRatingsByUserId($conn, $cid) { // used for editing or deleting comments of a user  
    $sql = "select MenuItemId, Value from Rating where UserId = " . $cid;
    $result = $conn->query($sql);

    if ($result) {
      $ratings = mysqli_fetch_all($result, MYSQLI_NUM);
      mysqli_free_result($result);
      $Ids = array();

      foreach ($ratings as $key => $value) {
        $Ids[$key] = $value[0];
      }

      return Array($ratings, $Ids);   
    }
    else {
      echo "Error retrieving Ratings: ", $conn->error;
    }
  }

  function addRating($conn, $Cid, $Mid, $value) {
    $sql = "insert into `Rating` (UserId, MenuItemId, Value) values (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iid", $Cid, $Mid, $value);

    if ($stmt->execute() === TRUE) {
       return true;
      //return "Comment Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function updateRating($conn, $Cid, $Mid, $value) {
    $sql = "update `Rating` set Value = (?) where UserId = (?) and  MenuItemId = (?) ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dii", $value, $Cid, $Mid);

    if ($stmt->execute() === TRUE) {
       return true;
      //return "Comment Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function checkOwnershipOfRatingForUserId($conn, $Mid, $Cid) { // check if its for the customer before deleting
    $sql = "select count(*) from Rating where MenuItemId = " . $Mid . " and UserId = " . $Cid;
    $result = $conn->query($sql);

    if ($result) {
      $count = mysqli_fetch_array($result, MYSQLI_NUM);
      $count = (int)$count[0];

      if ($count === 1) {
        return true;
      }
      else {
        return false;
      }
    }
  }

  function calcAvgRatingByMenuItemId($conn, $id) {
    $sql = "select avg(value) from Rating where MenuItemId = " . $id;
    $result = $conn->query($sql);

    if ($result) {
      $avg = mysqli_fetch_all($result, MYSQLI_NUM);
      mysqli_free_result($result);
      return $avg;
    }
    else { // server
      echo "Error retrieving average: ", $conn->error; // developer
    }
  }
?>