<?php
  require(__DIR__ . '/../Controllers/MenuItem.php');
  require(__DIR__ . '/../connection.php');
  require(__DIR__ . '/../session.php');
  require(__DIR__ . '/TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset($_GET['categoryId']) && testInt($_GET['categoryId']) ) {
      checkResult( getMenuItemByCategoryId($conn, $_GET['categoryId'], false, true) );
    }
    elseif (isset($_GET['id']) && testInt($_GET['id']) && $_SESSION['roleId'] == 1) {
      checkResult( getMenuItemById($conn, $_GET['id']) );
    }
    else {
      echo "Error while returning MenuItem";
    }
  }

  // i don't know how to handle
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['roleId'] == 1) {
      //decode the json data
      $data = json_decode( file_get_contents('php://input') ); // ????????????

      if ( isset($data->CategoryId, $data->Price, $data->Name, $data->Description, $data->Image) && testInt($data->CategoryId) && normalizeString($conn, $data->Name, $data->Description, $data->Image) && testPrice($data->Price) ) {
        addMenuItem($conn, $data->Name, $data->Price, $data->Description, $data->CategoryId, $data->Image);
      }
      else {
        echo "error while adding menuitem";
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if ($_SESSION['roleId'] == 1) {
      //decode the json data
      $data = json_decode( file_get_contents('php://input') );

      if ( isset($data->Id, $data->Price, $data->Visible, $data->Name, $data->Description, $data->Image) && testInt($data->Id, $data->Visible) && normalizeString($conn, $data->Name, $data->Description, $data->Image) && testPrice($data->Price) ) {
        editMenuItem($conn, $data->Name, $data->Price, $data->Description, $data->Id, $data->Image, $data->Visible);
      }
      else {
        echo "error while editiing menuitem";
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_SESSION['roleId'] == 1) {
      if (isset($_GET['menuItemId']) && testInt($_GET['menuItemId']) ) {
        deleteMenuItem($conn, $_GET['menuItemId']);
      }
      else {
        echo "Id error";
      }
    }
  }

  require('../footer.php');
?>