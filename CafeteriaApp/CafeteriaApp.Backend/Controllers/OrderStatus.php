<?php
function getOrderStatus($conn) {
  $sql = "select * from OrderStatus";
  $result = $conn->query($sql);

  if ($result) {
    $OrderStatus = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result); 
    return $OrderStatus;
  }
  else {
    echo "Error retrieving OrderStatus: ", $conn->error;
  }
}

function getOrderStatusById($conn, $id) {
  $sql = "select * from OrderStatus where Id = " . $id . " LIMIT 1";
  $result = $conn->query($sql);

  if ($result) {
    $OrderStatus = mysqli_fetch_assoc($result);
    mysqli_free_result($result); 
    return $OrderStatus;
  }
  else {
    echo "Error retrieving OrderStatus: ", $conn->error;
  }
}

function addOrderStatus($conn, $name) {
  $sql = "insert into OrderStatus (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $name);

  if ($stmt->execute() === TRUE) {
    return "OrderStatus Added successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}

function editOrderStatus($conn, $name, $id) {
  $sql = "update OrderStatus set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si", $name, $id);
  
  if ($stmt->execute() === TRUE) {
    return "OrderStatus updated successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}

function deleteOrderStatus($conn, $id) {
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from OrderStatus where Id = " . $id . " LIMIT 1";

  if ($conn->query($sql) === TRUE) {
    return "OrderStatus deleted successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}
?>