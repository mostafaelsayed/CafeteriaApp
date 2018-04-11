<?php
	function getOrderLocation($conn, $orderId) {
		$stmt = "select `orderlocation`.`Lat`, `orderlocation`.`Lng` from `orderlocation` where `orderlocation`.`OrderId` = " . $orderId;
		$res = $conn->query($stmt);

		if ($res) {
			$res = mysqli_fetch_assoc($res);
			return $res;
		}
		else {
			echo "error: ", $conn->error;
		}
	}

	function addOrderLocation($conn, $orderId, $userId, $lat, $lng) {
		$sql = "insert into `orderlocation` (`OrderId`, `UserId`, `Lat`, `Lng`) values (?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
	    $stmt->bind_param("iidd", $orderId, $userId, $lat, $lng);

	    if ($stmt->execute() === TRUE) {
	      echo "Order Location Added successfully";
	    }
	    else {
	    	echo $conn->error;
	    }
	}

	function updateOrderLocation($conn, $orderId, $lat, $lng) {
		$sql = "update `orderlocation` set `Lat` = {$lat}, `Lng` = {$lng} where `OrderId` = {$orderId}";
		$r = $conn->query($sql);

		if (!$r) {
			echo $conn->error;
		}
	}
?>