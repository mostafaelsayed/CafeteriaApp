<?php
require_once( 'CafeteriaApp.Backend/Controllers/Feedback.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once("CafeteriaApp.Backend/validation_functions.php");
require_once ('CheckResult.php');

print_r(checkTodaysFeedbackForMailOrPhone($conn,'',"mm_h434@yahoo.com")) ;

if ($_SERVER['REQUEST_METHOD']=="GET")
  { 
 if(isset($_GET["MenuItemId"]))
  {
    //$comments =(getCommentsByMenuItemId($conn,$_GET["MenuItemId"]));
    //$commentsIdsForCustomer=getCommentsIdsByUserIdAndMenuItemId($conn,$_SESSION["userId"], $_GET["MenuItemId"]);
    //checkResult(array($comments ,$commentsIdsForCustomer));
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
    if ($data->Name != null)
    {
     checkResult(addVisitorFeedback($conn,$data->Name,$data->Phone,$data->Mail,$data->Message,$data->SelectedAboutId));
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
  if (isset($_GET["id"]))
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