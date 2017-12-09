<?php
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Location.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/session.php');
require('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if ( isset( $_GET["userId"] ) && test_int( $_GET["userId"] ) ) {
    checkResult( getUserLocations( $conn,$_GET["userId"] ) );
  }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $data = json_decode( file_get_contents("php://input") );
  if ( isset($data->lat, $data->lng) ) {
	checkResult( addUserLocation($conn, $data->lat, $data->lng) );
  }
  else {
  	echo "error";
  }
}

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');
?>