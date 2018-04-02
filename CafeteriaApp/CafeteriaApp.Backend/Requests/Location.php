<?php
  require(__DIR__ . '/../Controllers/Location.php');
  require(__DIR__ . '/../connection.php');
  require(__DIR__ . '/../session.php');
  require(__DIR__ . '/TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset( $_GET['userId'] ) && testInt( $_GET['userId'] ) ) {
      checkResult( getUserLocations($conn, $_GET['userId']) );
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->lat, $data->lng) ) {
      checkResult( addUserLocation($conn, $data->lat, $data->lng) );
    }
    else {
    	echo "error";
    }
  }

  require('../footer.php');
?>