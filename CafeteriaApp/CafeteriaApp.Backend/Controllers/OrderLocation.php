<?php
	function getOrderLocation($conn, $orderId) {
		$stmt = "select `location`.`Lat`, `location`.`Lng` from `orderlocation` inner join `location` on `location`.`Id` = `orderlocation`.`LocationId` where `orderlocation`.`OrderId` = " . $orderId;
		$res = $conn->query($stmt);

		if ($res) {
			$res = mysqli_fetch_assoc($res);
			return $res;
		}
		else {
			echo "error: ", $conn->error;
		}
	}
?>