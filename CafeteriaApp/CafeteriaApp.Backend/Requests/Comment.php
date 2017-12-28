<?php
  require('../session.php');
  require('../Controllers/Comment.php');
  require('../connection.php');
  require('TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
   if ( isset($_GET['MenuItemId']) && test_int($_GET['MenuItemId']) && isset($_SESSION['userId']) ) {
      $comments = getCommentsByMenuItemId($conn, $_GET['MenuItemId']);
      $commentsIdsForCustomer = getCommentsIdsByUserIdAndMenuItemId($conn, $_SESSION['userId'], $_GET['MenuItemId']);
      checkResult( array($comments, $commentsIdsForCustomer) );
    }
    else {
      echo "Error occured while returning Comments";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->Details) && normalize_string($conn, $data->Details) && isset($_SESSION['userId']) && isset($data->MenuItemId) && test_int($data->MenuItemId) ) {
     checkResult( addComment($conn, $data->Details, $_SESSION['userId'], $data->MenuItemId) );
    }
    else {
      echo "error";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->Details) && normalize_string($conn, $data->Details) && isset($_SESSION['userId']) && isset($data->Id) && test_int($data->Id) ) {
      if ( checkOwnershipOfComment($conn, $data->Id, $_SESSION['userId']) ) {
        editComment($conn, $data->Details, $data->Id);
      }
      else {
        echo "Error occured while returning Comments";
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') { 
    if ( isset($_GET['id']) && test_int($_GET['id']) && isset($_SESSION['userId']) ) {
      if ( checkOwnershipOfComment($conn, $_GET['id'], $_SESSION['userId']) ) {
        deleteComment($conn, $_GET['id']);
      }
    }
    else {
      echo "Error occured while returning Comments";
    }
  }

  require('../footer.php');
?>