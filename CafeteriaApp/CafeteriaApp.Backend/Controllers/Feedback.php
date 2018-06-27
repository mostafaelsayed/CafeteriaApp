<?php
  function getVisitorFeedbackByDate($conn, $id) {
    $Date = date("Y-m-d");
    $sql = "select * from visitorfeedback where Date = " . $Date;
    $result = $conn->query($sql);

    if ($result) {
      $feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);

      return $feedbacks;
    }
    else { //server
      echo "Error retrieving Feedbacks: ", $conn->error;//developer
    }
  }

  function getfeedbacks($conn) {
    $sql = "select * from visitorfeedback";
    $result = $conn->query($sql);

    if ($result) {
      $feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);

      return $feedbacks;
    }
    else { //server
      echo "Error retrieving Feedbacks: ", $conn->error; // developer
    }
  }

  function checkTodaysFeedbackForMailOrPhone($conn, $phone, $mail) {
    $Date = date("Y-m-d");
    $sql = "select count(*) from visitorfeedback where Date = '" . $Date . "' and Email = '" . $mail . "' or Date = '" . $Date . "' and Phone = '" . $phone . "' ";
    $result = $conn->query($sql);

    if ($result) {
      $feedbacks = mysqli_fetch_array($result, MYSQLI_NUM);
      mysqli_free_result($result);
      
      return $feedbacks[0] > 0 ? true : false;
    }
    else { //server
      echo "Error retrieving Feedbacks: ", $conn->error; // developer
    }
  }

  function addVisitorFeedback($conn, $name, $phone, $mail, $message, $aboutId) {
    $Date = date("Y-m-d");
    $sql = "insert into visitorfeedback (Name, Phone, Email, Message, Date, AboutId) values (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $phone, $mail, $message, $Date, $aboutId);

    if ($stmt->execute() === TRUE) {
      return  mysqli_insert_id($conn);
      //return "Comment Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteVisitorFeedback($conn, $id) { // check if its for the customer before deleting
    $sql = "delete from visitorfeedback where Id = " . $id . " LIMIT 1";
    
    if ($conn->query($sql) === TRUE) {
      return "Visitor Feedback deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>