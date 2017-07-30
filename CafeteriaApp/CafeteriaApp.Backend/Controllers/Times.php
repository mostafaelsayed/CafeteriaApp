<?php
include 'CafeteriaApp.Backend\connection.php';

function getTimes($conn) {
  
  $sql = "select * from Times";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $times = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $times = json_encode($times);
      $conn->close();
      echo $times;
  } else {
      echo "Error retrieving Times: " . $conn->error;
  }
}

function getTimeById($conn,$id) {
    if( !isset($id)) 
 {
 echo "Error: Time Id is not set";
  return;
  }
  else{
  $sql = "select * from Times where Id=".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $times = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $times = json_encode($times);
      $conn->close();
      echo $times;
  } else {
      echo "Error retrieving Times: " . $conn->error;
  }
}
}

// function addTimes($conn,$n) {
//   $sql = "insert into Times (Time) values (?)";
//   $stmt = $conn->prepare($sql);
//   $stmt->bind_param("s",$name);
//   $name = $n;
//   //$conn->query($sql);
//   if ($stmt->execute()===TRUE) {
//     echo "Time Added successfully";
//   }
//   else {
//     echo "Error: ".$conn->error;
//   }
// }


 ?>
