<?php
function checkCSRFToken() {
    if ( isset($_POST['csrf_token']) ) {
        if ( hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']) ) {
            return true;
        }
        else {
            echo 'error';
            
            return false;
        }
    }
    else {
        $data = json_decode( file_get_contents('php://input') );
        $csrf_token = '';

        if ( isset($data->csrf_token) ) {
            $csrf_token = $data->csrf_token;
        }
        else {
            echo "error";

            return false;
        }

        if ( hash_equals($_SESSION['csrf_token'], $csrf_token) ) {
            echo true;

            return true;
        }
        else {
            echo 'error';
           
            return false;
        }
    }
}


function testPrice(&$value) {
    $value = trim($value);
    $x     = preg_match('/^\d{0,9}(\.\d{0,9})?$/', $value);

    if (!$x) {
        echo "false price";
        return false;
    }

    return true;
}

function testDateOfBirth(&$value) {
    if (!$value) {
        return false;
    }

    try {
        new \DateTime($value);
        return true;
    } catch (\Exception $e) {
        return false;
    }
    // $value = trim($value);
    // $x = preg_match('/^\d{4}-[0-9]([0-9])?-\d{1,2}$/', $value);

    // if (!$x) {
    //     echo "false date of birth";
    //     return false;
    // }

    // return true;
}

function testEmail(&$value) {
    $value = trim($value);
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

function normalizeString($conn, &...$values) {
    foreach ($values as &$value) {
        $value = trim($value);

        if ($value !== "") {
            $value = str_replace('&', 'and', $value);
            $value = mysqli_real_escape_string($conn, $value);
            $value = htmlspecialchars($value);
        }
        else {
            return false;
        }
    }

    return true;
}

function hasMaxLength($value, $max) {
    return strlen($value) <= $max;
}

function validateMaxLengths($fields_with_max_lengths) {
    // Expects an assoc. array
    foreach ($fields_with_max_lengths as $field => $max) {
        $value = trim($field);

        if ( !has_max_length($value, $max) ) {
            echo "max length exceeded";
            return false;
        }
    }

    return true;
}

function testPhone(&$value) {
    $value = trim($value);

    if ( preg_match('/^\d{0,13}$/', $value) ) {
        return true;
    }

    return false;
}

function testInt($value) {
    if (filter_var($value, FILTER_VALIDATE_INT) !== null) {
        return true;
    }
}

function testMutipleInts(&...$values) {

    foreach ($values as &$value) {
        if ( !ctype_digit($value) && !( is_int($value) || is_double($value) ) ) {
            //echo "false integer";
            return false;
        }
    }

    return true;
}

function testPassword(&$password) {
    $password = trim($password);
    $x        = preg_match('/^([a-zA-Z\d]){8,}$/', $password);
    $y        = preg_match('/([A-Z])/', $password);

    if (!$x || !$y) {
        return false;
    }

    return true;
}

function checkResult($result) {
    if ( isset($result) ) {
        echo json_encode($result);
    }
}