<?php
// Autoload SDK package for composer based installations
require 'C:/Users/DELL/vendor/autoload.php';

// define('site_url','http://127.0.0.1/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php');
define('SITE_URL','http://127.0.0.1/paypal');

$paypal = new \PayPal\Rest\ApiContext(
  new \PayPal\Auth\OAuthTokenCredential(
    'AX0jX0W_VH9Nef7XwrCEENhtf43mOE8FoNU_QUy5lpKkowSbGNWwrNklAPgTxb9Sy_1m5Kdu3cHNopLk',
    'EDzF2C7HP0W3CS63fB10QLIP96smQ8VYb1UQMgTeCeUMUJRRzf_mCjx9IMyEMkkZrI7tQOFOqwTB7hFH'
  )
);
?>