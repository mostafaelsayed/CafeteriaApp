<?php
include 'CafeteriaApp.Backend\connection.php';


function getOrdersByCustomerId($conn,$id) {
  
  $sql = "select * from orders where CustomerId = $id";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      echo $orders;
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}




function addOrder($n,$CustomerId) {
  $connection = new Connection();
  $conn = $connection->check_connection();
  $sql = "insert into Order (Name,CustomerId) values (?,?)"; // string should be quoted like that (single quotes)
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  if ($stmt->execute()===TRUE) {
    echo "Order Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
  $conn->close();
}



if ($_SERVER['REQUEST_METHOD']=="GET") {
  if ($_GET["Id"] != null) {
    getOrdersByCustomerId($conn,$_GET["Id"]);
  }
  else {
    echo "Error occured while returning Orders";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addOrder" && $data->CustomerId != null && $data->Name != null){
        addOrder($conn,$data->Name,$data->CustomerId);
      }
      else{
        echo "error occured while creating Order";
      }
}
?>
