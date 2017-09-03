<?php

function getBranches($conn)
{
	$sql = "select * from Branch";
  	if ($result = $conn->query($sql))
  	{
    	$branch = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
    	mysqli_free_result($result);
	    return $branch;
	}
	else
	{
	    echo "error retrieving Branch : " . $conn->error;
	}
}
?>