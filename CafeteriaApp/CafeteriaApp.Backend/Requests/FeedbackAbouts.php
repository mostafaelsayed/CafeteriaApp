<?php
  require(__DIR__ . '/../Controllers/FeedbackAbouts.php');
  require(__DIR__ . '/../connection.php');
  require(__DIR__ . '/TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    checkResult( getFeedbackAbouts($conn) );
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->name) && normalizeString($conn, $data->$name) ) {
     checkResult( addFeedbackAbouts($conn, $data->$name) );
    }
    else {
      echo "error";
    }
  }

  require('../footer.php');
?>