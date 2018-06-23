<?php
	function getBranches($conn) {
		$sql = "select * from `branch`";

	  	if ( $result = $conn->query($sql) ) {
	    	$branch = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
	    	mysqli_free_result($result);
	    	
		    return $branch;
		}
		else {
		    echo "error retrieving Branch : ", $conn->error;
		}
	}
?>