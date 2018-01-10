<?php
  // Autoload SDK package for composer based installations
  require('vendor/autoload.php');

  use PayPal\Rest\ApiContext;
  use PayPal\Auth\OAuthTokenCredential;

  define('SITE_URL', 'http://127.0.0.1');

  $paypal = new ApiContext(
    new OAuthTokenCredential(
      //'AX0jX0W_VH9Nef7XwrCEENhtf43mOE8FoNU_QUy5lpKkowSbGNWwrNklAPgTxb9Sy_1m5Kdu3cHNopLk',
      //'EDzF2C7HP0W3CS63fB10QLIP96smQ8VYb1UQMgTeCeUMUJRRzf_mCjx9IMyEMkkZrI7tQOFOqwTB7hFH'
      'AZGPDIWL1MdLuKBv5ZVzGDR88znU4MuHKYn2aFsWvkf9qgqAcEUn9naOEY3j5ZRmPKasJ51xQm09dgLh',
      'EMmWv7NS4w3Z9hq-Piffsb5H1NWE_d4GA2TnmfYnG2UdKouUlpHRDidQImgNhcU8VOaeCTRZhHlnTjxf'
      //'AaqK9FmuMGv1QG5LkOV3feVs9rrJHh-Aq61u9U50pAxmRvJ6p0zEUKgcLHJaE_BwWPJqemP6CNeGbdmm',
      //'ENiYI0eZcHx2bXoYTj0392coGpSXNUAB6_NeLfjYqX57dT5BCfz1rjHMvyr-UdgYY5zAxUbpSetQnTW7s'

    )
  );

  $paypal->setConfig([
  	'mode' => 'sandbox',
  	'http.ConnectionTimeOut' => 30,
  	'log.LogEnabled' => false,
  	'log.FileName' => '',
  	'log.LogLevel' => 'FINE',
  	'validation.level' => 'log'
  ]);
?>