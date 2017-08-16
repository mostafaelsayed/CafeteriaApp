<?php
 require_once("CafeteriaApp.Backend/session.php");
require_once( 'CafeteriaApp.Backend/Controllers/Languages.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{  
  checkResult(getLanguages($conn));
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (isset($_GET["Id"]))
  {
    deleteLanguage($conn,$_GET["Id"]);
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
  if ($data->langId != null)
  {
    $_SESSION["langId"]=$data->langId;
  }
  else
  {
    echo "language Id is required";
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->Name != null && $data->Id != null)
  {
    editLanguage($conn,$data->Name,$data->Id);
  }
  else
  {
    echo "name is required";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>