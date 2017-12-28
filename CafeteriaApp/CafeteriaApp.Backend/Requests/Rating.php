<?php
  require('../session.php');// must be first as it uses cookies 
  require('../Controllers/Rating.php');
  require('../connection.php');
  require('TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset($_SESSION['userId']) ) {
      checkResult( getMenuItemsIdsThatHaveRatingsByUserId($conn, $_SESSION['userId']) );
    }
    else {
      echo "Error occured while returning Ratings";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if (isset($data->MenuItemId) && test_int($data->MenuItemId) && isset($_SESSION['userId']) && $data->Value <= 5) {
    	if ( !checkOwnershipOfRatingForUserId($conn, $data->MenuItemId, $_SESSION['userId']) ) {
    	 addRating($conn, $_SESSION['userId'], $data->MenuItemId, $data->Value);
    	}
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if (isset($data->MenuItemId) && test_int($data->MenuItemId) && isset($_SESSION['userId']) && $data->Value <= 5) {
      updateRating($conn, $_SESSION['userId'], $data->MenuItemId, $data->Value);
    }
    else {
      echo "name is required";
    }
  }

  require('../footer.php');
?>