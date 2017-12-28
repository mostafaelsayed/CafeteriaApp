<?php 
  require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/session.php');// must be first as it uses cookies

  function getCurrentCustomerinfoByUserId($conn) {
    $sql = "select * from Customer inner join User on Customer.UserId = User.Id where Customer.UserId = " . $_SESSION['userId'] . " LIMIT 1";
    $result = $conn->query($sql);

    if ($result) {
      $customer = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $customer;
    }
    else {
      echo "Error retrieving customer: ", $conn->error;
    }
  }

  function getCustomerByUserId($conn, $userId) {
    $sql = "select * from Customer where UserId = '{$userId}' LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result) {
      $customer = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $customer;
    }
    else {
      echo "Error retrieving customer: ", $conn->error;
    }
  }

  function addCustomer($conn, $cred, $dob, $userId, $genderId) {
    $sql = "insert into Customer (Credit, DateOfBirth, UserId, GenderId) values (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsii", $cred, $dob, $userId, $genderId);

    if ($stmt->execute() === TRUE) {
      $customer_id = mysqli_insert_id($conn);
      return $customer_id;
    }
    else {
      return false;
    }
  }

  function editCustomer($conn, $cred, $genderId, $dob, $userId) {
    $sql = "update `Customer` set `Credit` = (?) , GenderId = (?) , DateOfBirth = (?) where UserId = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("disi", $cred, $genderId, $dob, $userId);
    
    if ($stmt->execute() === TRUE) {
      return "Customer updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteCustomerByUserId($conn, $userId) { // cascaded delete ??
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from Customer where UserId = " . $userId . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "Customer deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteCustomer($conn, $id) {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from Customer where Id = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "Customer deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>