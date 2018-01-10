<?php 
  function getNotificationByUserId($conn, $userId) {	
    $sql = "select Message.Content from Notification inner join Message on Notification.MessageId = Message.Id where UserId = " . $userId;
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
    $sql = "insert into Notification (UserId, MessageId) values (?, ?)";
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
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from Notification where UserId = " . $id;
    if ($conn->query($sql) === TRUE) {
      return "Notifications deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>