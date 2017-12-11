<?php
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Fee.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/session.php');
require('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  //if ($_SESSION['roleId'] == 1) {
    if ( isset($_GET['id']) && test_int($_GET['id']) ) {
      checkResult( getFeeById($conn, $_GET['id']) );
    }
    else {
      checkResult( getFees($conn) );
    }
  //}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($_SESSION['roleId'] == 1) {
    $data = json_decode( file_get_contents("php://input") );
    if ( normalize_string($conn, $data->Name) && test_price($data->Price) ) {
      addFee($conn, $data->Name, $data->Price);
    }
    else {
      echo "error";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
  if ($_SESSION['roleId'] == 1) {
    //decode the json data
    $data = json_decode( file_get_contents("php://input") );
    if ( isset($data->Id, $data->Price) && test_int($data->Id) && normalize_string($conn, $data->Name) && test_price($data->Price) ) {
      editFee($conn, $data->Id, $data->Name, $data->Price);
    }
    else {
      echo "error";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  if ($_SESSION['roleId'] == 1) {
    if ( isset($_GET['feeId']) && test_int($_GET['feeId']) ) {
      deleteFee($conn, $_GET['feeId']);
    }
    else {
      echo "No Id is provided";
    }
  }
}

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');
?>