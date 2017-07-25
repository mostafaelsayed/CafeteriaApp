<?php
class Connection {
  public function check_connection() {
    $conn = new mysqli("localhost", "root", "yarab3592", "myDB");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else {
      return $conn;
    }
  }
}
?>
