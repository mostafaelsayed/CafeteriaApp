<?php
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/FeedbackAbouts.php');
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');
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



require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');

?>