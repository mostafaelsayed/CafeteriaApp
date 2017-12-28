<?php
function getDates($conn) {
  $sql = "select * from `Dates`";
  $result = $conn->query($sql);

  if ($result) {
    $dates = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $dates;
  }
  else {
    echo "Error retrieving Dates: ", $conn->error;
  }
}

function getDateById($conn, $id) {
  $sql = "select Date from `Dates` where Id = " . $id . " LIMIT 1";
  $result = $conn->query($sql);

  if ($result) {
    $Id = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $Id;
  }
  else {
    echo "Error retrieving Date: ", $conn->error;
  }
}

function getDateIdByDate($conn, $value) {
  $sql = "select Id from `Dates` where `Date` = '{$value}'";
  $result = $conn->query($sql);

  if ($result) {
    $dateId = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $dateId['Id'];
  }
  else {
    echo "Error retrieving Dates: ", $conn->error;
  }
}

function getCurrentDateId($conn) { // CURDATE() mysql
  $today = date("Y-m-d");
  $sql = "select Id from `Dates` where `Date` = STR_TO_DATE('{$today}', '%Y-%m-%d')";
  $result = $conn->query($sql);

  if ($result) {
    $date = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    if ( isset($date['Id']) ) {
      return $date['Id'];
    }
    else {
      return false;
    }
  }
  else {
    echo "Error retrieving Date Id: ", $conn->error;
  }
}
?>