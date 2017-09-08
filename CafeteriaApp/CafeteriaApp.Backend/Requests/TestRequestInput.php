<?php

function test_price($value)
{
	$value = trim($value);
	return preg_match('/^\d{0,9}(\.\d{0,9})?$/',$value);
}

function test_date_of_birth($value)
{
	$value = trim($value);
	return preg_match('/^\d{4}-[1-9]([0-9])?-\d{1,2}$/',$value);
}

function test_email(&$value)
{
	$value = trim($value);
	return (filter_var($value,FILTER_VALIDATE_EMAIL));
}

function normalize_string($conn,&...$values)
{
	foreach ($values as &$value)
	{
		$value = trim($value);
		if ($value !== "")
		{
			$value = str_replace('&','and',$value);
			$value = mysqli_real_escape_string($conn,$value);
			$value = htmlspecialchars($value);
		}
		else
		{
			return false;
		}
	}
	return true;
}

function has_max_length($value,$max)
{
	return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths)
{
	// Expects an assoc. array
	foreach ($fields_with_max_lengths as $field => $max)
	{
		$value = trim($field);
	  	if (!has_max_length($value,$max))
	  	{
	   		return false;
	 	}
	}
}

function test_phone(&$value)
{
	$value = trim($value);
	if (!(preg_match('/^\d{0,13}$/',$value)))
	{
		return false;
	}
	return true;
}

function test_int(&...$values)
{
	foreach ($values as &$value)
	{
		if (!ctype_digit($value) && !is_int($value))
		{
			return false;
		}
	}
	return true;
}

?>