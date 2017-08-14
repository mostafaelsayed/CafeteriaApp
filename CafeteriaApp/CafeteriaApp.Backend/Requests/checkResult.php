<?php
function checkResult($result)
{
	if ($result)
	{
		echo json_encode($result);
	}
	else
	{
		$returnUrl = "CafeteriaApp.Frontend/Areas/Public/showing cafeterias.php";
		header("Location: {$returnUrl}");
	}
}
?>