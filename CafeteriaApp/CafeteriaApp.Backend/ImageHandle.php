<?php
    function addImageFile($image, $name, $target_file = null) {
        $target_dir = "../uploads/" . $name . ".jpg"; // use relative

        if ($target_file == null) {
            $target_file = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/uploads/" . $name . ".jpg";
        }
        
        if ( file_put_contents( $target_dir, base64_decode($image) ) ) {
            echo "The file has been uploaded.";
        }
        else {
            echo "Sorry, there was an error uploading your file.";
        }
        
        return $target_file;
    }

    function editImage($imageData, $imageAttr, $name) {
        if ($imageAttr != null) {
            deleteImageFileIfExists($imageAttr);
        }

        return addImageFile($imageData, $name, $imageAttr);
    }

    function deleteImageFileIfExists($imageAttr) {
        $imageFileName = basename($imageAttr);
        chdir("../uploads");

        if ( file_exists($imageFileName) ) {
            unlink($imageFileName); // remove it
            return 1;
        }
        else {
            return 0;
        }
    }
?>