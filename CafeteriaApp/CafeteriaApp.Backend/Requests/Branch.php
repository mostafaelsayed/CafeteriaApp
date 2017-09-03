<?php
require_once( 'CafeteriaApp.Backend/Controllers/Branch.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
    checkResult(getBranches($conn));
}

require_once("CafeteriaApp.Backend/footer.php");

?>