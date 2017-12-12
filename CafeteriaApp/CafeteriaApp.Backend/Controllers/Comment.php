<?php
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Dates.php'); 

//result=getCommentsByMenuItemId();
//if(result)
 // echo json_encode(result);
//if add or edit , echo a message
//else
// redirect to fear the hacker

function getCommentsByMenuItemId($conn, $id) {
  $sql = "select User.UserName , Comment.Id ,Comment.Details ,Dates.Date from Comment inner join User on Comment.UserId=User.Id inner join Dates on Dates.Id=Comment.DateId where MenuItemId =" . $id;
  $result = $conn->query($sql);

  if ($result) {
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $comments;
  }
  else { // server
    echo "Error retrieving Comments: ", $conn->error; // developer
  }
}

function getCommentsByUserId($conn, $id) { // used for editing or deleting comments of a user  
  $sql = "select * from Comment where UserId = " . $id;
  $result = $conn->query($sql);

  if ($result) {
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $comments;
  }
  else {
    echo "Error retrieving Comments: ", $conn->error;
  }
}

function getCommentsIdsByUserIdAndMenuItemId($conn, $cid, $mid) { // used for editing or deleting comments of a user 
  $sql = "select Id from Comment where UserId = '" . $cid . "' and MenuItemId = " . $mid;
  $result = $conn->query($sql);

  if ($result) {
    $comments = mysqli_fetch_all($result, MYSQLI_NUM);
    mysqli_free_result($result);

    foreach ($comments as $key => $value) {
      $comments[$key] = $value[0];
    }

    return $comments;
  }
  else {
    echo "Error retrieving Comments: ", $conn->error;
  }
}

function addComment($conn, $details, $Cid, $Mid) {
  $DateId = getDateIdByDate( $conn, date("Y-m-d") );
  $sql = "insert into Comment (Details, UserId, MenuItemId, DateId) values (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("siii", $details, $Cid, $Mid, $DateId);

  if ($stmt->execute() === TRUE) {
    return  mysqli_insert_id($conn);
    //return "Comment Added successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}

function editComment($conn, $details, $id) { // check the customer if he owns the comment
  $DateId = getDateIdByDate( $conn,date("Y-m-d") );
  $sql = "update Comment set Details = (?) , DateId= (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sii", $details, $DateId, $id);
  
  if ($stmt->execute() === TRUE) {
    return "Comment updated successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}

function checkOwnershipOfComment($conn, $id, $cid) { // check if its for the customer before deleting
  $sql = "select count(*) from Comment where Id = " . $id . " and UserId = " . $cid;
  $result = $conn->query($sql);

  if ($result) {
    $count = mysqli_fetch_array($result , MYSQLI_NUM);
    $count = (int)$count[0];

    if ($count === 1) {
      return true;
    }
    else {
      return false;
    }
  }
}

function deleteComment($conn, $id) { // check if its for the customer before deleting
  $sql = "delete from Comment where Id = " . $id . " LIMIT 1";
  
  if ($conn->query($sql) === TRUE) {
    return "Comment deleted successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}
?>