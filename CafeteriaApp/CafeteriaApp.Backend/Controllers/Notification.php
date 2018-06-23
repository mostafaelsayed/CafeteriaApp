<?php 
  function getNotificationByUserId($conn, $userId) {	
    $sql = "select message.Content from notification inner join message on notification.MessageId = message.Id where UserId = " . $userId;
  	$result = $conn->query($sql);
    
  	if ($result) {
  		$notifictions = mysqli_fetch_all($result, MYSQLI_NUM);
  		mysqli_free_result($result);

      foreach ($notifictions as $key => $value) {
        $notifictions[$key] = $value[0];
      }

  		return $notifictions;
  	}
  	else {
  		echo "Error retriving notifictions", $conn->error;
  	}
  }

  function addNotification($conn, $Uid, $Mid) {
    $sql = "insert into notification (UserId, MessageId) values (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $Uid, $Mid);
    
    if ($stmt->execute() === TRUE) {
      return "Notification Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteNotificationsByUserId($conn, $id) { // cascaded delete ??
    $sql = "delete from notification where UserId = " . $id;

    if ($conn->query($sql) === TRUE) {
      return "Notifications deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>