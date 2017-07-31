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
