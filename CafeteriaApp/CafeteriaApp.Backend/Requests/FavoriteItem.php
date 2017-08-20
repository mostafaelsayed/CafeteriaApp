<?php
require_once("CafeteriaApp.Backend/session.php");
require_once( 'CafeteriaApp.Backend/Controllers/FavoriteItem.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');


if ($_SERVER['REQUEST_METHOD']=="GET")
{  
  checkResult(getFavoriteItemsByUserId($conn,$_SESSION["userId"]));
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (isset($_GET["MenuItemId"]))
  {
    deleteFavoriteItemByMenuItemId($conn,$_SESSION["userId"],$_GET["MenuItemId"]);
  }
  else
  {
    echo "Error occured while deleting Favorite Item ";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  
    if ($data->menuItemId != null)
    {
      addFavoriteItem($conn,$_SESSION["userId"],$data->menuItemId);
    }
    else
    {
      echo "menuItem Id is required";
    }
  
}



require_once("CafeteriaApp.Backend/footer.php");

?>