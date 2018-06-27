<?php
require __DIR__ . '/../Controllers/Branch.php';
require __DIR__ . '/../connection.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    checkResult(getBranches($conn));
}

require '../footer.php';