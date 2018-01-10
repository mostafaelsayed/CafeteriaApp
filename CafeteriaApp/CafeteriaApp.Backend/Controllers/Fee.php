<?php
  function getFees($conn) {
  	$sql = "select * from fees";

    if ( $result = $conn->query($sql) ) {
      $fees = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
      mysqli_free_result($result);
      return $fees;
  	}
  	else {
      echo "error retrieving fees : ", $conn->error;
  	}
  }

  function getFeeById($conn, $id) {
    $sql = "select * from fees where Id = " . $id . " LIMIT 1";

    if ( $result = $conn->query($sql) ) {
      $fee = mysqli_fetch_assoc($result); // fetch only the first row of the result
      mysqli_free_result($result);
      return $fee;
    }
    else {
      echo "Error retrieving fee : ", $conn->error;
    }
  }

  function deleteFee($conn, $id) {
    $sql = "delete from fees where Id = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "fee deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function addFee($conn, $name, $price = 0.00) {
  	$sql = "insert into fees (Name, Price) values (?, ?)";
  	$stmt = $conn->prepare($sql);
  	$stmt->bind_param("sd", $name, $price);

    if ($stmt->execute() === TRUE) {
      return "Fee Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function editFee($conn, $id, $name, $price = 0.00) {
    $sql = "update fees set Name = (?) , Price = (?) where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $name, $price, $id);

    if ($stmt->execute() === TRUE) {
      return "fee updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>