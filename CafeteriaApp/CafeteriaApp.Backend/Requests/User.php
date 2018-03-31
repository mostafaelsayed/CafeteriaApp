<?php
  require(__DIR__.'/../Controllers/User.php');
  require(__DIR__.'/TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_SESSION['roleId'] == 1) { // admin only can call these methods
      if ( isset($_GET['userId']) && test_int($_GET['userId']) ) {
        checkResult( getUserById($conn, $_GET['userId']) );
      }
      else {
        checkResult( getUsers($conn) );
      }
    }
    else if (isset($_GET['flag']) && $_GET['flag'] == 1) {
      echo $_SESSION['roleId'];
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['roleId'] == 1) {
      //decode the json data
      $data = json_decode( file_get_contents('php://input') );
      $result = normalize_string($conn, $data->UserName, $data->FirstName, $data->LastName, $data->Password) && test_phone($data->PhoneNumber) && test_email($data->Email);

      if ( $result && isset($data->RoleId) && test_int($data->RoleId) ) {
        normalize_string($conn, $data->Image);
        echo addUser($conn, $data->UserName, $data->FirstName, $data->LastName, $data->Image, $data->Email, $data->PhoneNumber, $data->Password, $data->RoleId, 1);
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if ($_SESSION['roleId'] == 1) {
      //decode the json data
      $data = json_decode( file_get_contents('php://input') );
      $result = normalize_string($conn, $data->UserName, $data->FirstName, $data->LastName) && test_phone($data->PhoneNumber) && test_email($data->Email);
      
      if ( $result && isset($data->RoleId, $data->Id) && test_int($data->RoleId, $data->Id) ) {
        normalize_string($conn, $data->Image);
        editUser($conn, $data->UserName, $data->FirstName, $data->LastName, $data->Email, $data->Image, $data->PhoneNumber, $data->RoleId, $data->Id);
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_SESSION['roleId'] == 1) {
      //decode the json data
      if ( isset($_GET['userId']) && test_int($_GET['userId']) ) {
        deleteUser($conn, $_GET['userId']);
      }
    }
  }

  require('../footer.php');
?>