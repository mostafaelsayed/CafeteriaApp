<?php
function addUserLocation($conn, $lat, $lng) {
	$sql = "select `Id` from `location` where `Lat` = " . $lat . " and `Lng` = " . $lng;
	$res = $conn->query($sql);
	if ($res === false) {
		echo "error: ", $conn->error;
	}
	else if ( mysqli_num_rows($res) !== 0 ) {
		echo "location already exists";
	}
	else {
		$stmt = "insert into `location` (UserId, Lat, Lng) values (?, ?, ?)";
		$stmt = $conn->prepare($stmt);
		$stmt->bind_param("idd", $UserId, $Lat, $Lng);
		$UserId = $_SESSION['userId'];
		$Lat = $lat;
		$Lng = $lng;
		$res = $stmt->execute();

		if ($res) {
			return mysqli_insert_id($conn);
		}
		else {
			echo "error: ", $conn->error;
		}
	}
}
?>