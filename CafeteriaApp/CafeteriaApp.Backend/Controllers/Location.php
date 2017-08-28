<?php

function addLocation($conn,$placeId,$placeName,$placeAddress,$userId)
{
	$sql = "select Id from `location` where `PlaceId` = '$placeId'";
	$result = $conn->query($sql);
	if ($result->num_rows == 0) // no place in the database with this id
	{
		$sql = "insert into `location` (PlaceId,PlaceName,PlaceAddress) values (?,?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss",$PlaceId,$PlaceName,$PlaceAddress);
		$PlaceId = $placeId;
		$PlaceName = $placeName;
		$PlaceAddress = $placeAddress;
		if ($stmt->execute() === true)
		{
			$locationId = mysqli_insert_id($conn);
			addUserLocation($conn,$locationId,$userId);
			//return $locationId;
		}
		else
		{
			echo "error adding location: " . $conn->error;
		}
	}
	else
	{
		global $flag;
		$flag = 0;
		$userLocations = getUserLocations($conn,$userId);
		foreach ($userLocations as $location)
		{
			if ($location[0] == $placeId)
			{
				// $locationId = mysqli_fetch_assoc($result)["Id"];
				// addUserLocation($conn,$locationId,$userId);
				$flag = 1;
				break;
			}
		}
		if ($flag === 0)
		{
			$locationId = mysqli_fetch_assoc($result)["Id"];
			addUserLocation($conn,$locationId,$userId);
		}
		else
		{
			return "location already exists";
		}
	}
}

// function getLocationByPlaceId($conn,$plaeId)
// {
// 	$sql = "select * from location where PlaceId = " . $placeId;
// 	$result = $conn->query($sql)
// 	if ($result)
// 	{
// 		$location = mysqli_fetch_assoc($result);
// 		return $location;
// 	}
// 	else
// 	{
// 		echo "error getting location: " . $conn->error;
// 	}
// }

function addUserLocation($conn,$locationId,$userId)
{
	$sql = "insert into `userlocations` (UserId,LocationId) values (?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ii",$UserId,$LocationId);
	$UserId = $userId;
	$LocationId = $locationId;
	if ($stmt->execute() === true)
	{
		return "user location added succesfully";
	}
	else
	{
		echo "error adding user location: " . $conn->error;
	}
}

function getUserLocations($conn,$userId)
{
	$sql = "select PlaceId,PlaceName,PlaceAddress from userlocations inner join location on location.Id = userLocations.LocationId where UserId = " . $userId;
	if ($result = $conn->query($sql))
	{
		$userLocation = mysqli_fetch_all($result);
		var_dump($userLocation);
		return $userLocation;
	}
	else
	{
		echo "error: " . $conn->error;
	}
}

// require_once('CafeteriaApp.Backend/connection.php');

// addLocation($conn,"ChIJf4-dC8k9WBQR3fUzN3JwYaM","Al Hay Al Asher, Madinet Nasr, Cairo Governorate, Egypt","Bad El Sharkya",5);
// function getLocationByUserId($conn,$userId)
// {
// 	$sql = "select * from userlocation where UserId = " . $userId;
// 	$result = $conn->query($sql)
// 	if ($result)
// 	{
// 		$location = mysqli_fetch_assoc($result);
// 		return $location;
// 	}
// 	else
// 	{
// 		echo "error getting location: " . $conn->error;
// 	}
// }