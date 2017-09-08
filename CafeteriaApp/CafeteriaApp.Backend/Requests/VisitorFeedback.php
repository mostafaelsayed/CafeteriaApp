<?php
require_once( 'CafeteriaApp.Backend/Controllers/Feedback.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once("CafeteriaApp.Backend/validation_functions.php");
require_once('TestRequestInput.php');


if ($_SERVER['REQUEST_METHOD']=="GET")
  { 
 if(isset($_GET["MenuItemId"])&& test_int($_GET["MenuItemId"]))
  {
    $feedbacks =(getfeedbacks($conn));
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
    if (isset($data->Name)&&isset($data->Phone)&&isset($data->Mail)&&isset($data->Message)&& isset($data->SelectedAboutId))
    {
      if(normalize_string($conn,$data->Name)&&test_phone($data->Phone)&&test_email($data->Mail)&&normalize_string($conn,$data->Message)&&test_int($data->SelectedAboutId))
        
     checkResult(addVisitorFeedback($conn,$data->Name,$data->Phone,$data->Mail,$data->Message,$data->SelectedAboutId));
    }
    else
    {
    echo "";
    }
  }


require_once("CafeteriaApp.Backend/footer.php");

?>