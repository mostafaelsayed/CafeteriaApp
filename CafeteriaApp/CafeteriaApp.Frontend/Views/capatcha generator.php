<?php
session_start();
include("capatchas/simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Example &raquo; A simple PHP CAPTCHA script</title>
    <style type="text/css">
        pre {
            border: solid 1px #bbb;
            padding: 10px;
            margin: 2em;
        }

        img {
            border: solid 1px #ccc;
            margin: 0 2em;
        }
    </style>
</head>
<body>
    <p>
        <?php
        echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';

        ?>
    </p>
    <input type="text" name="" value="<?php echo $_SESSION['captcha']['code']  ; ?>">
    </body>
</html>


<?php

	// configurations

// $_SESSION['captcha'] = simple_php_captcha( array(
//     'min_length' => 5,
//     'max_length' => 5,
//     'backgrounds' => array(image.png', ...),
//     'fonts' => array('font.ttf', ...),
//     'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
//     'min_font_size' => 28,
//     'max_font_size' => 28,
//     'color' => '#666',
//     'angle_min' => 0,
//     'angle_max' => 10,
//     'shadow' => true,
//     'shadow_color' => '#fff',
//     'shadow_offset_x' => -1,
//     'shadow_offset_y' => 1
// ));

?>