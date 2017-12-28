<?php
  require('../Controllers/Category.php');
  require('../connection.php');
  require('TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset($_GET['cafeteriaId']) && !isset($_GET['id']) && test_int($_GET['cafeteriaId']) ) {
      checkResult( getByCafeteriaId($conn, $_GET['cafeteriaId']) );
    }
    elseif ( isset($_GET['id']) && !isset($_GET['cafeteriaId']) && test_int($_GET['cafeteriaId']) ) {
      checkResult( getCategoryById($conn, $_GET['id']) );
    }
    else {
      echo "Error occured while returning categories";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->Name, $data->CafeteriaId) && normalize_string($conn, $data->Name) && test_int($data->CafeteriaId) ) {
      if ( !isset($data->Image) ) {
        addCategory($conn, $data->Name, $data->CafeteriaId);
      }
      elseif ( isset($data->Image) && normalize_string($conn, $data->Image) ) {
        addCategory($conn, $data->Name, $data->CafeteriaId, $data->Image);
      }
    }
    else {
      if ( !isset($data->Name) ) {
        echo "Error: Name is Required";
      }
      elseif ( !isset($data->CafeteriaId) ) {
        echo "Error: No Cafeteria Id is Provided";
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->Id, $data->Name) && normalize_string($conn, $data->Name) && test_int($data->Id) ) {
      if ( !isset($data->Image) ) {
        editCategory($conn, $data->Name, $data->Id);
      }
      else {
        if ( normalizeString($conn, $data->Image) )
          editCategory($conn, $data->Name, $data->Id, $data->Image);
      }
    }
    else {
      echo "name is required";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ( !isset($_GET['categoryId']) && test_int($_GET['categoryId']) ) {
      deleteCategory($conn, $_GET['categoryId']);
    }
    else {
      echo "No Id is provided";
    }
  }

  require('../footer.php');
?>