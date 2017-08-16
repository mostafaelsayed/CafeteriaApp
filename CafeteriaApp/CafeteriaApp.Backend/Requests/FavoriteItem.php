<?php
require_once("CafeteriaApp.Backend/session.php");
require_once( 'CafeteriaApp.Backend/Controllers/FavoriteItem.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('checkResult.php');


if ($_SERVER['REQUEST_METHOD']=="GET")
{  
  checkResult(getFavoriteItemsByCustomerId($conn,$_SESSION["customerId"]));
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (isset($_GET["Id"]))
  {
    deleteFavoriteItemByMenuItemId($conn,$_SESSION["customerId"],$_GET["Id"]);
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
      addFavoriteItem($conn,$_SESSION["customerId"],$data->menuItemId);
    }
    else
    {
      echo "menuItem Id is required";
    }
  
}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->Name != null && $data->Id != null)
  {
    editFavoriteItem($conn,$data->Name,$data->Id);
  }
  else
  {
    echo "name is required";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>