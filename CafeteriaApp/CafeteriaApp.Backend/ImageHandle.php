<?php
    function addImageFile($image, $name, $x1 = null, $y1 = null, $w = null, $h = null, $dirChanged = 0) {
        $x = strrpos(dirname($_SERVER['PHP_SELF']), '/'); // directory path (without localhost part)
        $y = substr(dirname($_SERVER['PHP_SELF']), 0, $x);

        if ($dirChanged == 0) {
            chdir("../../.."); // inside php dir
        }

        $target_dir = __DIR__ . "\uploads\\";
        $target_file = $target_dir . $name;

        // Check file size
        // if ($image['size'] > 500000) {
        //     echo "Sorry, your file is too large.";
        //     exit();
        // }
        
        // Allow certain file formats
        $imageFileType = exif_imagetype($image['tmp_name']); // file type (supposed to be image type in our case)

        $croppedImage = '';

        if ($imageFileType != 2 && $imageFileType != 3) {
            echo "Sorry, only JPG, JPEG & PNG files are allowed.";
            exit();
        }

        if ($imageFileType == 2) {
            $imageName = $y . '/uploads/' . $name . '.jpeg';
            $croppedImageName = $y . '/uploads/' . $name . '_crop.jpeg';
        }
        elseif ($imageFileType == 3) {
            $imageName = $y . '/uploads/' . $name . '.png';
            $croppedImageName = $y . '/uploads/' . $name . '_crop.png';
        }

        if ($x1 === null && $y1 === null && $w === null && $h === null) {
            if ($imageFileType == 2) {
                move_uploaded_file( $image['tmp_name'], $croppedImage . '.jpeg');
            }
            elseif ($imageFileType == 3) {
                move_uploaded_file( $image['tmp_name'], $croppedImage . '.png');
            }
        }
        else {
            $croppedImage = $target_file . '_crop';

            if ($imageFileType == 2) { // jpeg
                $croppedImage .= '.jpeg';
                $target_file .= '.jpeg';

                move_uploaded_file( $image['tmp_name'], $croppedImage);
                copy($croppedImage, $target_file);
            }
            elseif ($imageFileType == 3) { // png
                $croppedImage .= '.png';
                $target_file .= '.png';
                
                move_uploaded_file( $image['tmp_name'], $croppedImage);
                copy($croppedImage, $target_file);
            }

            // crop image
            // Create our small image
            $new = imagecreatetruecolor(150, 150);
            // Create original image
            $current_image = 0;

            if ($imageFileType == 2) {
                $current_image = imagecreatefromjpeg($croppedImage);
            }
            else {
                $current_image = imagecreatefrompng($croppedImage);
            }

            $whiteBackground = imagecolorallocate($new, 255, 255, 255);
            imagefill($new, 0, 0, $whiteBackground); // fill the background with white

            // resamling (actual cropping)
            imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, 150, 150, $w, $h);
            // creating our new image

            if ($imageFileType == 2) {
                imagejpeg($new, $croppedImage, 95);
            }
            else {
                imagepng($new, $croppedImage, 9);
            }

            imagedestroy($new);
        }
        
        return [$imageName, $croppedImageName];
    }

    function crop($image, $x1, $y1, $w, $h, $type) {
        // crop image
        // Create our small image
        $new = imagecreatetruecolor(150, 150);
        // Create original image
        $current_image = 0;

        if ($type == 2) {
            $current_image = imagecreatefromjpeg($image);
        }
        else {
            $current_image = imagecreatefrompng($image);
        }

        $whiteBackground = imagecolorallocate($new, 255, 255, 255);
        imagefill($new, 0, 0, $whiteBackground); // fill the background with white

        // resampling (actual cropping)
        imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, 150, 150, $w, $h);
        // creating our new image

        if ($type == 2) {
            imagejpeg($new, $image, 95);
        }
        else {
            imagepng($new, $image, 9);
        }

        imagedestroy($new);
    }

    function handlePictureUpdate($conn, $image, $x1 = null, $y1 = null, $w = null, $h = null) {
        if ($x1 != null || $y1 != null || $w != null || $h != null) {
            if ($image['size'] != 0) { // new image is gonna be uploaded
                $imageFileType = exif_imagetype($image['tmp_name']);

                if ($imageFileType != 2 && $imageFileType != 3) {
                    echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                    exit();
                }

                $ext = pathinfo($_SESSION['image'], PATHINFO_EXTENSION);
                $x = strrpos(dirname($_SERVER['PHP_SELF']), '/');
                $y = substr(dirname($_SERVER['PHP_SELF']), 0, $x);
                $imageName = $y . '/uploads/' . $_SESSION['email'];
                $croppedImageName = $y . '/uploads/' . $_SESSION['email'] . '_crop';

                if ($imageFileType == 2) {
                    if ($ext != 'jpeg') {
                        $_SESSION['image'] = $imageName . '.jpeg';
                        $_SESSION['croppedImage'] = $croppedImageName . '.jpeg';

                        if (!$conn->query("update `User` set `Image` = '{$_SESSION['image']}' where `Id` = '{$_SESSION['userId']}'") ) {
                            die(var_dump($conn->error));
                        }
                        if (!$conn->query("update `User` set `CroppedImage` = '{$_SESSION['croppedImage']}' where `Id` = '{$_SESSION['userId']}'") ) {
                            die(var_dump($conn->error));
                        }

                        unlink(__DIR__ . '\uploads\\' . $_SESSION['email'] . '.png'); // remove the old picture
                        unlink(__DIR__ . '\uploads\\' . $_SESSION['email'] . '_crop.png'); // remove the old cropped
                    }
                    else {
                        unlink(__DIR__ . '\uploads\\' . $_SESSION['email'] . '.jpeg'); // remove the old picture
                        unlink(__DIR__ . '\uploads\\' . $_SESSION['email'] . '_crop.jpeg'); // remove the old 
                    }
                }
                else {
                    if ($ext != 'png') {
                        $_SESSION['image'] = $imageName . '.png';
                        $_SESSION['croppedImage'] = $croppedImageName . '.png';

                        if (!$conn->query("update `User` set `Image` = '{$_SESSION['image']}' where `Id` = '{$_SESSION['userId']}'") ) {
                            die(var_dump($conn->error));
                        }
                        if (!$conn->query("update `User` set `CroppedImage` = '{$_SESSION['croppedImage']}' where `Id` = '{$_SESSION['userId']}'") ) {
                            die(var_dump($conn->error));
                        }
                        unlink(__DIR__ . '\uploads\\' . $_SESSION['email'] . '.jpeg'); // remove the old picture
                        unlink(__DIR__ . '\uploads\\' . $_SESSION['email'] . '_crop.jpeg'); // remove the old cropped
                    }
                    else {
                        unlink(__DIR__ . '\uploads\\' . $_SESSION['email'] . '.png'); // remove the old picture
                        unlink(__DIR__ . '\uploads\\' . $_SESSION['email'] . '_crop.png'); // remove the old 
                    }
                }

                addImageFile($image, $_SESSION['email'], $x1, $y1, $w, $h);
            }
            else {
                $ext = pathinfo($_SESSION['image'], PATHINFO_EXTENSION);
                $img = __DIR__ . '\uploads\\' . $_SESSION['email'];
                $cropped = __DIR__ . '\uploads\\' . $_SESSION['email'] . '_crop';

                if ($ext == 'jpeg') {
                    $ext = 2;
                    $img = $img . '.jpeg';
                    $cropped =  $cropped . '.jpeg';
                    unlink($cropped);
                }
                elseif ($ext == 'png') {
                    $ext = 3;
                    $img = $img . '.png';
                    $cropped = $cropped . '.png';
                    unlink($cropped);
                }
                
                copy($img, $cropped);
                crop($cropped, $x1, $y1, $w, $h, $ext);
            }
        }
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
        $imgdata = base64_decode($image);

        $f = finfo_open(FILEINFO_MIME_TYPE);

        $type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);        

        if ($type != 'image/jpeg' && $type != 'image/png') {
            return "not a valid image type";
        }
        else {
            if ($type == 'image/jpeg') {
                $name = $name . '.jpeg';
            }
            elseif ($type == 'image/png') {
                $name = $name . '.png';
            }
        }

        $image = base64_decode($image);
        $target_file = __DIR__ . "\uploads\\" . $name;
        file_put_contents($target_file, $image);
        $x = strrpos(dirname($_SERVER['PHP_SELF']), '/');
        $y = substr(dirname($_SERVER['PHP_SELF']), 0, $x);
        $fileName = $y . '/uploads/' . $name;

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