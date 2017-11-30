<?php
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Branch.php');
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');
require('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
    checkResult(getBranches($conn));
}

require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');

?>