<?php

function getFees($conn)
{
	$sql = "select * from fees";
  	if ($result = $conn->query($sql))
  	{
    	$fees = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
    	mysqli_free_result($result);
	    return $fees;
	}
	else
	{
	    echo "error retrieving fees : " . $conn->error;
	}
}

function getFeeById($conn,$id)
{
  if (!isset($id)) 
  {
    return;
  }
  else
  {
    $sql = "select * from fees where Id =".$id." LIMIT 1";
    if ($result = $conn->query($sql))
    {
      $fee = mysqli_fetch_assoc($result); // fetch only the first row of the result
      mysqli_free_result($result);
      return $fee;
    }
    else
    {
      echo "Error retrieving fee : " . $conn->error;
    }
  }
}

function deleteFee($conn,$id)
{
	if (!isset($id))
  	{
    	//echo "Error: Id is not set";
    	return;
  	}
  	else
  	{
	    $sql = "delete from fees where Id = ".$id." LIMIT 1";
	    if ($conn->query($sql)===TRUE)
	    {
	      return "fee deleted successfully";
	    }
	    else
	    {
	      echo "Error: ".$conn->error;
	    }
	}
}

function addFee($conn,$name,$price=0.00)
{
	if (!isset($name)) //deal with the hacker
	{
	    //echo "Error: Name is not set";
		return;
	}
	else
	{
		$sql = "insert into fees (Name,Price) values (?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sd",$Name,$Price);
		$Name = $name;
		$Price = $price;

	    if ($stmt->execute() === TRUE)
	    {
	      return "Fee Added successfully";
	    }
	    else
	    {
	      echo "Error: ".$conn->error;
	    }
	}
}

function editFee($conn,$id,$name,$price=0.00)
{
	
  if(!isset($name) || !isset($id))
  {
   // echo "Error: Name is not set";
    return;
  }
  else
  {
    $sql = "update fees set Name = (?) , Price = (?) where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi",$Name,$Price,$Id);
    $Name = $name;
    $Price = $price;
    $Id = $id;

    if ($stmt->execute()===TRUE)
    {
      return "fee updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>
