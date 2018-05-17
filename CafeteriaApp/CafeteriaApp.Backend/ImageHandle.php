<?php
    function addImageFile($image, $name, $x1 = null, $y1 = null, $w = null, $h = null, $dirChanged = 0) {
        if ($dirChanged == 0) {
            chdir("../../.."); // inside php dir
        }

        $target_dir = "CafeteriaApp/CafeteriaApp.Backend/uploads/";
        $target_file = $target_dir . $name; // trailing name normalized (validation)

        // Check file size
        // if ($image['size'] > 500000) {
        //     echo "Sorry, your file is too large.";
        //     exit();
        // }
        
        // Allow certain file formats
        $imageFileType = exif_imagetype($image['tmp_name']); // file type (supposed to be image type in our case)

        if ($imageFileType != 2 && $imageFileType != 3) {
            echo "Sorry, only JPG, JPEG & PNG files are allowed.";
            exit();
        }

        else {
            if ($imageFileType == 2) { // jpeg
                $target_file .= '.jpeg';
            }
            elseif ($imageFileType == 3) { // png
                $target_file .= '.png';
            }

            move_uploaded_file( $image['tmp_name'], $target_file);
        }

        if ($x1 !== null) { // only one is enough as others must also be not zero (later in requests)
            // crop image
            //var_dump($x1);
            // Create our small image
            $new = imagecreatetruecolor(150, 150);
            // Create original image
            $current_image = 0;

            if ($imageFileType == 2) {
                $current_image = imagecreatefromjpeg($target_file);
            }
            else {
                $current_image = imagecreatefrompng($target_file);
            }

            $whiteBackground = imagecolorallocate($new, 255, 255, 255);
            imagefill($new, 0, 0, $whiteBackground); // fill the background with white

            // resamling (actual cropping)
            imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, 150, 150, $w, $h);
            // creating our new image

            if ($imageFileType == 2) {
                imagejpeg($new, $target_file, 95);
            }
            else {
                imagepng($new, $target_file, 9);
            }

            imagedestroy($new);
        }
        
        return "/CafeteriaApp/" . $target_file;
    }

    function editBinaryImage($imageData, $imageAttr, $userName, $x1 = null, $y1 = null, $w = null, $h = null) {
        $dirChanged = 0;

        if ($imageAttr != null) {
            if (deleteImageFileIfExists($imageAttr) == 1) {
                $dirChanged = 1;
            }
        }

        return addBinaryImageFile($imageData, $userName, $x1, $y1, $w, $h, $dirChanged);
    }

    function editImage($imageData, $imageAttr, $userName) {
        $dirChanged = 0;

        if ($imageAttr != null) {
            if (deleteImageFileIfExists($imageAttr) == 1) {
                $dirChanged = 1;
            }
        }

        return addImageFile($imageData, $userName);
    }

    function addBinaryImageFile($image, $name, $x1 = null, $y1 = null, $w = null, $h = null, $dirChanged = 0) {
        list($type, $image) = explode(';', $image);

        if ($type != 'data:image/jpeg' && $type != 'data:image/png') {
            return "not a valid image type";
        }
        else {
            if ($type == 'data:image/jpeg') {
                $name = $name . '.jpeg';
            }
            elseif ($type == 'data:image/png') {
                $name = $name . '.png';
            }
        }

        list(, $image) = explode(',', $image);

        //var_dump($type);
        $image = base64_decode($image);
        $target_file = __DIR__ . "\uploads\\" . $name;
        file_put_contents($target_file, $image);
        $fileName = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/uploads/" . $name;

        return $fileName;
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