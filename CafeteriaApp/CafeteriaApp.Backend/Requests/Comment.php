<?php
require_once("CafeteriaApp.Backend/session.php");
require_once( 'CafeteriaApp.Backend/Controllers/Comment.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');



if ($_SERVER['REQUEST_METHOD']=="GET")
  { 
 if(isset($_GET["MenuItemId"]))
  {
    $comments =(getCommentsByMenuItemId($conn,$_GET["MenuItemId"]));
    checkResult(array($comments ,$commentsIdsForCustomer));
  }
  else
  {
    echo "Error occured while returning Comments";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
    if ($data->Details != null)
    {
    }
    else
    {
    echo "";
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
    echo "Error occured while returning Comments";
  }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{ 
  if (isset($_GET["id"]))
     { deleteComment($conn,$_GET["id"]);
   
   }
  }
  else
  {
    echo "Error occured while returning Comments";
  }
}


require_once("CafeteriaApp.Backend/footer.php");

?>