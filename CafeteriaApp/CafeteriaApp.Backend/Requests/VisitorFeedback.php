<?php
  require('../Controllers/Feedback.php');
  require('../connection.php');
  require('../validation_functions.php');
  require('TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    if ( isset($_GET['MenuItemId']) && test_int($_GET['MenuItemId']) ) {
      $feedbacks = getfeedbacks($conn);
    }
    else {
      echo "Error occured while returning Comments";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->Name, $data->Phone, $data->Mail, $data->Message, $data->SelectedAboutId) ) {
      if ( normalize_string($conn, $data->Name, $data->Message) && test_phone($data->Phone) && test_email($data->Mail)  && test_int($data->SelectedAboutId) )
        checkResult( addVisitorFeedback($conn, $data->Name, $data->Phone, $data->Mail, $data->Message, $data->SelectedAboutId) );
    }
    else {
      echo "error";
    }
  }

  require('../footer.php');
?>