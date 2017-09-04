<?php
require_once( 'CafeteriaApp.Backend/Controllers/FeedbackAbouts.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');
require_once ('TestRequestInput.php');


if ($_SERVER['REQUEST_METHOD']=="GET")
  { 
    checkResult(getFeedbackAbouts($conn));
}



if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
    if (isset($data->name) && normalize_string($conn,$data->$name))
    {
     checkResult(addFeedbackAbouts($conn,$data->$name));
    }
    else
    {
    echo "";
    }
  }



require_once("CafeteriaApp.Backend/footer.php");

?>