<?php

require_once( 'CafeteriaApp.Backend/Controllers/Fee.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  if (isset($_GET["id"]))
  {
    checkResult(getFeeById($conn,$_GET["id"]));
  }
  else
  {
    checkResult(getFees($conn));
  }
}

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->Name))
  {
    addFee($conn,$data->Name,$data->Price);
  }
  else
  {
    echo "error";
  }
}

if ($_SERVER['REQUEST_METHOD'] == "PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->Name) && isset($data->Id) && isset($data->Price) && $data->Price != null && $data->Name != null && $data->Id != null)
  {
    editFee($conn,$data->Id,$data->Name,$data->Price);
  }
  else
  {
    echo "error";
  }
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE")
{
  $feeIdToDelete = $_GET["feeId"];
  if ($feeIdToDelete != null)
  {
    deleteFee($conn,$feeIdToDelete);
  }
  else
  {
    echo "No Id is provided";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>