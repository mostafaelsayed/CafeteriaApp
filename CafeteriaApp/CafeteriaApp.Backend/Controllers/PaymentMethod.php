<?php
function getPaymentMethods($conn) {
  $sql = "select * from PaymentMethod";
  $result = $conn->query($sql);

  if ($result) {
    $paymentMethods = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $paymentMethods;
  }
  else {
    echo "Error retrieving PaymentMethods : ", $conn->error;
  }
}

function getPaymentMethodById($conn, $id) {
  $sql = "select * from PaymentMethod where Id = " . $id . " LIMIT 1";
  $result = $conn->query($sql);

  if ($result) {
    $paymentMethods = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $paymentMethods;
  }
  else {
    echo "Error retrieving PaymentMethod : ", $conn->error;
  }
}

function addPaymentMethod($conn, $name) {
  $sql = "insert into PaymentMethod (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $name);

  if ($stmt->execute() === TRUE) {
    return "PaymentMethod Added successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}

function editPaymentMethod($conn, $name, $id) {
  $sql = "update PaymentMethod set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si", $name, $id);
  
  if ($stmt->execute() === TRUE) {
    return "PaymentMethod updated successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}

function deletePaymentMethod($conn, $id) {
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from PaymentMethod where Id = " . $id . " LIMIT 1";

  if ($conn->query($sql) === TRUE) {
    return "PaymentMethod deleted successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}
?>