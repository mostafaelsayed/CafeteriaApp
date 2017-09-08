<?php
require_once("CafeteriaApp.Backend/session.php");
require_once( 'CafeteriaApp.Backend/Controllers/Comment.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');
require_once ('TestRequestInput.php');



if ($_SERVER['REQUEST_METHOD']=="GET")
  { 
 if(isset($_GET["MenuItemId"]) && is_int($_GET["MenuItemId"]) && isset($_SESSION["userId"]) && is_int($_SESSION["userId"]))
  {
    $comments =(getCommentsByMenuItemId($conn,$_GET["MenuItemId"]));
    $commentsIdsForCustomer=getCommentsIdsByUserIdAndMenuItemId($conn,$_SESSION["userId"], $_GET["MenuItemId"]);
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
    if (isset($data->Details) &&normalize_string($conn,$data->Details)&& isset($_SESSION["userId"]) && is_int($_SESSION["userId"]) &&isset($data->MenuItemId) && is_int($data->MenuItemId) )
    {
     checkResult(addComment($conn,$data->Details,$_SESSION["userId"],$data->MenuItemId));
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

   if (isset($data->Details) &&normalize_string($conn,$data->Details)&& isset($_SESSION["userId"]) && is_int($_SESSION["userId"]) && isset($data->Id) && is_int($data->Id) )
  {
   if(checkOwnershipOfComment($conn , $data->Id , $_SESSION["userId"]))
      editComment($conn,$data->Details,$data->Id);

  }
  else
  {
    echo "Error occured while returning Comments";
  }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{ 
 if(isset($_GET["id"]) && is_int($_GET["id"]) && isset($_SESSION["userId"]) && is_int($_SESSION["userId"]))
  { if(checkOwnershipOfComment($conn , $_GET["id"] , $_SESSION["userId"]))
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