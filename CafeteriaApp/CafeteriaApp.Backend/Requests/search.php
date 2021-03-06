<?php
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../connection.php';
require __DIR__ . '/../Controllers/MenuItem.php';
require __DIR__ . '/TestRequestInput.php';
require __DIR__ . '/../elastic-search.php';

use Elasticsearch\ClientBuilder;

require __DIR__ . '/../lib/vendor/autoload.php';

function filterData($conn, $searchInput)
{
    // $sql1    = "select * from Cafeteria where `Name` like '%{$searchInput}%'";
    // $sql2    = "select * from Category where `Name` like '%{$searchInput}%'";
    // $sql3    = "select * from MenuItem where `Name` like '%{$searchInput}%'";
    // $result1 = $conn->query($sql1);
    // $result2 = $conn->query($sql2);
    // $result3 = $conn->query($sql3);

    // if ($result1 && $result2 && $result3) {
    //     $arr1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
    //     $arr2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    //     $arr3 = mysqli_fetch_all($result3, MYSQLI_ASSOC);

    //     if ($arr1 === null) {
    //         $arr1 = [];
    //     }
    //     if ($arr2 === null) {
    //         $arr2 = [];
    //     }
    //     if ($arr3 === null) {
    //         $arr3 = [];
    //     }

    //     $_SESSION['filteredData'] = array_merge($arr1, $arr2, $arr3);
    //     header('Location: /filtered-data?query=' . $searchInput);
    // } else {
    //     echo "error : ", $conn->error;
    // }

    checkResult(search($conn, 'cafeteria', 'menuitem', 'Name', $searchInput));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['searchInput']) && normalizeString($_POST['searchInput'])) {
        filterData($conn, $_POST['searchInput']);
        $x = $_POST['searchInput'];
        header("Location: /filtered_data?query='{$x}'");
    }

    elseif (isset($_GET['query']) && normalizeString($_GET['query'])) {
        //echo "string";
        (filterData($conn, $_GET['query']));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode($_SESSION['filteredData']);
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if (isset($_GET['query']) && normalizeString($_GET['query'])) {
        foreach ($_SESSION['filteredData'] as $key => $value) {
            if ($value['Name'] == $_GET['query']) {
                $_SESSION['filteredData'] = [$value];
            }
        }
    }
}
