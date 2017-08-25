<?php
require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies 
require_once( 'CafeteriaApp.Backend/Controllers/Rating.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  if (isset($_SESSION["userId"]))
  {
    checkResult(getMenuItemsIdsThatHaveRatingsByUserId($conn,$_SESSION["userId"]));
  }
  else
  {
    echo "Error occured while returning Ratings";
  }
}


if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->MenuItemId) )
  {
    if ($data->MenuItemId != null)
    {
    	if(!checkOwnershipOfRatingForUserId($conn , $data->MenuItemId , $_SESSION["userId"]))
    	{
    	 addRating($conn, $_SESSION["userId"] ,$data->MenuItemId , $data->Value );
    	}
    }
  }
}


if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->Value != null && $data->MenuItemId != null)
  {
    updateRating($conn,$_SESSION["userId"],$data->MenuItemId,$data->Value);
  }
  else
  {
    echo "name is required";
  }
}


require_once("CafeteriaApp.Backend/footer.php");

?>




