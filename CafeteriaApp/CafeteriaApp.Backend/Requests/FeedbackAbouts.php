<?php
require_once( 'CafeteriaApp.Backend/Controllers/FeedbackAbouts.php');
require_once("CafeteriaApp.Backend/connection.php");
 require_once ('CheckResult.php');


if ($_SERVER['REQUEST_METHOD']=="GET")
  { 
    checkResult(getFeedbackAbouts($conn));
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
    if ($data->Details != null)
    {
     checkResult(addVisitorFeedback($conn,$name,$phone,$mail,$message,$aboutId));
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