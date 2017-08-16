<?php
require_once("CafeteriaApp.Backend/session.php");
require_once( 'CafeteriaApp.Backend/Controllers/Comment.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('checkResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
  { 
  if (isset($_GET["MenuItemId"]))
  {
    checkResult(getCommentsByMenuItemId($conn,$_GET["MenuItemId"]));
  }
  else
  {
    echo "Error occured while returning Details";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
    if ($data->Details != null)
    {
      addComment($conn,$data->Details,$_SESSION["customerId"],$data->MenuItemId );
    }
    else
    {
      echo "Details is required";
    }
  }


if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->Details != null && $data->Id != null)
  {
    editComment($conn,$data->Details,$data->Id);
  }
  else
  {
    echo "Details is required";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>