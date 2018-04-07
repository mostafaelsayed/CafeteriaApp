<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/connection.php';

function redirect_to($new_location)
{
    header("Location: " . $new_location);
    exit;
}

function confirm_query($result_set)
{
    if (!$result_set) {
        die('Database query failed.');
    }
}

function form_errors($errors = array())
{
    $output = "";

    if (!empty($errors)) {
        $output .= "<div class=\"error\"> ";
        $output .= "<h5 style='color:white;'>Please fix the following errors:<h5>";
        $output .= "<ul class=\"list-error\">";

        foreach ($errors as $key => $error) {
            $output .= "<li>";
            $output .= htmlentities($error);
            $output .= "</li>";
        }

        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

function password_encrypt($password)
{
    $hash_format     = "$2y$10$"; // Tells PHP to use Blowfish with a "cost" or rounds of 10
    $salt_length     = 22; // Blowfish salts should be 22-characters or more
    $salt            = generate_salt($salt_length);
    $format_and_salt = $hash_format . $salt;
    $hash            = crypt($password, $format_and_salt);
    return $hash;
}

function generate_salt($length)
{
    // Not 100% unique, not 100% random, but good enough for a salt
    // MD5 returns 32 characters
    $unique_random_string = md5(uniqid(mt_rand(), true));

    // Valid characters for a salt are [a-zA-Z0-9./]
    $base64_string = base64_encode($unique_random_string);

    // But not '+' which is valid in base64 encoding
    $modified_base64_string = str_replace('+', '.', $base64_string);

    // Truncate string to the correct length
    $salt = substr($modified_base64_string, 0, $length);

    return $salt;
}

function islogged_in()
{
    return (isset($_SESSION['userId'])); // for normal user and fb user check
}

function confirm_logged_in()
{
    if (!islogged_in()) {
        redirect_to('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/login.php');
    }
}

function attempt_login($conn, $email, $password)
{

    $user = getUserByEmail($conn, $email);
    // echo  $user ;
    if ($user) {
        // found user, now check password
        if (passwordCheck($password, $user["PasswordHash"])) {
            // password matches
            return $user;
        } else {
            // password does not match
            return false;
        }
    } else {
        // user not found
        return false;
    }
}

function getUserByEmail($conn, $email)
{
    if (!isset($email)) {
        echo "Error: User Email is not set";
        return;
    } else {
        $safe_email = mysqli_real_escape_string($conn, $email);
        $query      = "SELECT * ";
        $query .= "FROM user ";
        $query .= "WHERE Email = '{$safe_email}' ";
        $query .= "LIMIT 1";
        $user_set = $conn->query($query);
        //confirmQuery($user_set);
        // var_dump( $user_set);
        $user = mysqli_fetch_assoc($user_set);
        if ($user) {
            return $user;
        } else {
            return null;
        }
    }
}

function confirmQuery($result_set)
{
    if (!$result_set) {
        die('Database query failed.'); // not give the user who wants to login any info
    }
}

function passwordCheck($password, $existing_hash)
{
    // existing hash contains format and salt at start
    $hash = crypt($password, $existing_hash);
    if ($hash === $existing_hash) {
        return true;
    } else {
        return false;
    }
}

function validatePageAccess($permittedLevels, $checklogging = true)
{
    // want to permit for admin to see menus in its customer view
    if ($checklogging) {
        confirm_logged_in();
    }

    $permitted = false;
    foreach ($permittedLevels as $key => $value) {
        if ($value == $_SESSION['roleId']) {
            $permitted = true;
        }
    }

    if (!$permitted) {
        echo "<h1 style ='color:red;' > Access denied . </h2>";
        exit();
    }

    // $query  = "SELECT `Dir` FROM `dir` WHERE `Id` IN (SELECT `DirId` FROM `dir_role` WHERE `RoleId` = {$_SESSION['roleId']} ) ";  // add RoleId
    // $result_set = mysqli_query($conn, $query);
    // confirmQuery($result_set);

    // var_dump($result_set);

    // if ($result_set) {
    //   $dirs = mysqli_fetch_all($result_set, MYSQLI_ASSOC); // ??

    //   foreach ($dirs as $key => $value) {
    //     var_dump($value['Dir']);
    //     if (strpos( getcwd(), $value['Dir'] ) !== false) {
    //       return;
    //     }
    //   }
    //   var_dump(getcwd());

    //   echo "<h1 style ='color:red;' > Access denied . </h2>";
    //   exit();
    // }
}

function randomPassword()
{
    $alphabet    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass        = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

    for ($i = 0; $i < 10; $i++) {
        $n      = rand(0, $alphaLength);
        $pass[] = $alphabet[$n]; // add to the end of the array
    }

    return implode($pass); //turn the array into a string
}
