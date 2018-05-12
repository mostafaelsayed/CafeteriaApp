<?php 
  require_once(__DIR__ . '/../session.php'); // must be first as it uses cookies

  function getCurrentCustomerinfoByUserId($conn) {
    $sql = "select * from customer inner join user on customer.UserId = user.Id where customer.UserId = " . $_SESSION['userId'] . " LIMIT 1";
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
    $sql = "select * from customer where UserId = '{$userId}' LIMIT 1";
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

  function addCustomer($conn, $cred, $userId) {
    $sql = "insert into customer (Credit, UserId) values (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $cred, $userId);

    if ($stmt->execute() === TRUE) {
      $customer_id = mysqli_insert_id($conn);

      return $customer_id;
    }
    else {
      return false;
    }
  }

  function editCustomer($conn, $cred, $userId) {
    $sql = "update `customer` set `Credit` = (?) where UserId = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $cred, $userId);

    echo $cred;
    
    if ($stmt->execute() === TRUE) {
      return "Customer updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteCustomerByUserId($conn, $userId) { // cascaded delete ??
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from customer where UserId = " . $userId . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "Customer deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteCustomer($conn, $id) {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from customer where Id = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "Customer deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>