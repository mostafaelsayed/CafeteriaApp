<?php
include 'CafeteriaApp.Backend\connection.php';

function getTimes($conn,$backend=false) {

  $sql = "select * from Times";
  $result = $conn->query($sql);
  if ($result) {
      $times = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $times = json_encode($times);
      $conn->close();
      if($backend)
      {
        return $times;
      }
      else
      {
       echo $times;
      }

  } else {
      echo "Error retrieving Times: " . $conn->error;
  }
}

function getTimeById($conn,$id,$backend=false) {
    if( !isset($id))
 {
 echo "Error: Time Id is not set";
  return;
  }
  else{
  $sql = "select * from Times where Id=".$id." LIMIT 1";
  $result = $conn->query($sql);
  if ($result) {
      $times = mysqli_fetch_assoc($result);
      $times = json_encode($times);
      $conn->close();
      if($backend)
      {
        return $times;
      }
      else
      {
       echo $times;
      }

  } else {
      echo "Error retrieving Time: " . $conn->error;
  }
}
}

function addTime($conn) {
  $sql = "insert into Times (Time) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$time);
  $time = date("h:i:00");
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Time Added successfully";
    $stmt->close();
    return mysqli_insert_id($conn);
  }
  else {
    echo "Error: ".$conn->error;
  }
}
addTime($conn);
function deleteTime($conn,$id) {
  if (!isset($id)) {
   echo "Error: Id is not set";
    return;
    }
    else {
    //$conn->query("set foreign_key_checks=0");
    $sql = "delete from Times where Id = ".$id. " LIMIT 1";
    if ($conn->query($sql)===TRUE) {
      echo "Time deleted successfully";
    }
    else {
      echo "Error: ".$conn->error;
    }
  }
}


 ?>
