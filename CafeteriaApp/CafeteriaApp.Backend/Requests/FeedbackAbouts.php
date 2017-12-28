<?php
  require('../Controllers/FeedbackAbouts.php');
  require('../connection.php');
  require('TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    checkResult( getFeedbackAbouts($conn) );
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->name) && normalize_string($conn, $data->$name) ) {
     checkResult( addFeedbackAbouts($conn, $data->$name) );
    }
    else {
      echo "error";
    }
  }

  require('../footer.php');
?>