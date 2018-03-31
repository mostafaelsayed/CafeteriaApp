<?php
  require(__DIR__.'/Dates.php'); 

  function getVisitorFeedbackByDate($conn, $id) {
    $DateId = getCurrentDateId($conn);
    $sql = "select * from visitorfeedback where DateId = " . $DateId;
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
    $DateId = getCurrentDateId($conn);
    $sql = "select count(*) from visitorfeedback where DateId = '" . $DateId . "' and Email = '" . $mail . "' or DateId = '" . $DateId . "' and Phone = '" . $phone . "' ";
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
    $DateId = getDateIdByDate( $conn, date("Y-m-d") );
    $sql = "insert into visitorfeedback (Name, Phone, Email, Message, DateId, AboutId) values (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $phone, $mail, $message, $DateId, $aboutId);

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