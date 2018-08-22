<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/connection.php';

function redirect_to($new_location) {
    header("Location: " . $new_location);
    exit;
}

function confirm_query($result_set) {
    if (!$result_set) {
        die('Database query failed.');
    }
}

function form_errors( $errors = array() ) {
    $output = "";

    if ( !empty($errors) ) {
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



function islogged_in() {
    return isset($_SESSION['userId']); // for normal user and fb user check
}

function confirm_logged_in() {
    if ( !islogged_in() ) {
        redirect_to('/login');
    }
}

function attempt_login($conn, $email, $password) {

    $user = getUserByEmail($conn, $email);
    // echo  $user ;
    if ($user) {
        // found user, now check password
        if ( passwordCheck($password, $user["PasswordHash"]) ) {
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

function getUserByEmail($conn, $email) {
    if ( !isset($email) ) {
        echo "Error: User Email is not set";
        return;
    }
    else {
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
        }
        else {
            return null;
        }
    }
}

function confirmQuery($result_set) {
    if (!$result_set) {
        die('Database query failed.'); // not give the user who wants to login any info
    }
}

function passwordCheck($password, $existing_hash) {
    // existing hash contains format and salt at start
    $hash = crypt($password, $existing_hash);

    if ($hash === $existing_hash) {
        return true;
    }
    else {
        return false;
    }
}

function validatePageAccess($permittedLevels, $checklogging = true) {
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
        // echo "<h1 style ='color:red;' > Access denied ^_^ ! </h2>";
        // exit();
        redirect_to('/login');
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

function checkGetParams() {
    confirm_logged_in();

    // foreach ($_GET as $key => $value) {
    //     if ( !isset($_GET[$key]) || empty($_GET[$key]) ) {
    //         echo "<h1 style ='color:red;' > Access denied ^_^  </h2>";
    //         exit();
    //     }
    // }
}

function randomPassword() {
    $alphabet    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass        = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

    for ($i = 0; $i < 10; $i++) {
        $n      = rand(0, $alphaLength);
        $pass[] = $alphabet[$n]; // add to the end of the array
    }

    return implode($pass); //turn the array into a string
}
