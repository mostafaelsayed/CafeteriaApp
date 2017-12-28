<?php
  require('../session.php');
  require('../Controllers/FavoriteItem.php');
  require('../connection.php');
  require('TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {  
    if ( isset($_SESSION['userId']) )
      checkResult( getFavoriteItemsByUserId($conn, $_SESSION['userId']) );
  }

  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ( isset($_SESSION['userId']) && isset($_GET['MenuItemId']) && test_int($_GET['MenuItemId']) ) {
      deleteFavoriteItemByMenuItemId($conn, $_SESSION['userId'], $_GET['MenuItemId']);
    }
    else {
      echo "Error occured while deleting Favorite Item";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );
    
    if ( isset($_SESSION['userId']) && isset($data->menuItemId) && test_int($data->menuItemId) ) {
      addFavoriteItem($conn, $_SESSION['userId'], $data->menuItemId);
    }
    else {
      echo "menuItem Id is required";
    }
  }

  require('../footer.php');
?>