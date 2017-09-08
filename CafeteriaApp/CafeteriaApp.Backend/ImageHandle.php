<?php

function addImageFile($imageData,$dirChanged=0)
{
	if ($dirChanged == 0)
	{
		chdir("../uploads");
	}
    $imageFileName = str_replace(':',' ',(string)date("Y-m-d H:i:s")).".jpg";
    $ifp = fopen($imageFileName,"x+");
    fwrite($ifp,base64_decode($imageData));
    fclose($ifp);
    return "/CafeteriaApp.Backend/uploads/" . $imageFileName;
}

function editImage($imageData,$imageAttr)
{
    $dirChanged = 0;
    if ($imageAttr != null)
    {
    	if (deleteImageFileIfExists($imageAttr) == 1)
    	{
    		$dirChanged = 1;
    	}
    }
	return addImageFile($imageData,$dirChanged);
}

function deleteImageFileIfExists($imageAttr)
{
	$imageFileName = basename($imageAttr);
	chdir("../uploads");
    if (file_exists($imageFileName))
    {
      	unlink($imageFileName);
      	return 1;
    }
    else
    {
    	return 0;
    }
}

?>