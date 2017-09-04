<?php

function test_user_input($conn,$data)
{
	if (isset($data->UserName,$data->FirstName,$data->LastName,$data->Email,$data->PhoneNumber,$data->Image))
	{
		foreach ($data as $key => $value)
		{
			if ($key != "ConfirmPassword")
			{
				if (in_array($key, array("UserName","FirstName","LastName","Image")))
				{
					test_name($conn,$value);
				}
				elseif ($key == "PhoneNumber")
				{
					if (!(preg_match('/^\d{0,9}$/',$value)))
					{
						echo "false PhoneNumber";
						return false;
					}
				}
				elseif ($key == "Email")
				{
					if (!(filter_var($value, FILTER_VALIDATE_EMAIL)))
					{
						echo "false email";
						return false;
					}
				}
				elseif ($key == "Password")
				{
					if (!(strlen($value) >= 8))
					{
						echo "false password";
						return false;
					}
				}
			}
		}
		return true;
	}
	else
	{
		return false;
	}
}

function test_price($conn,$value)
{	$value = trim($value);
	return preg_match('/^\d{0,9}(\.\d{0,9})?$/',$value);
}

function test_date_of_birth($conn,$value)
{	$value = trim($value);
	return preg_match('/^\d{4}-[1-9]([0-9])?-\d{1,2}$/',$value);
}

function test_name($conn,&$value)
{
	$value = trim($value);
	$value = mysqli_real_escape_string($conn,$value);
	$value = htmlspecialchars($value);
}

 function test_email($value)
{		$value = trim($value);
	return (filter_var($value, FILTER_VALIDATE_EMAIL));
}

function normalize_string($conn,&$value)
{	
	$value = trim($value);
	if($value!=="")
	{
	$value = mysqli_real_escape_string($conn,$value);
	$value = htmlspecialchars($value);
	return true;
		}
		return false;
}

 function test_phone($value)
{		$value = trim($value);
	if (!(preg_match('/^\d{0,9}$/',$value)))
			return false;
	return true;
}

?>