<?php
  if ( !session_id() ) {
    session_start();
  }

  // Include the autoloader provided in the SDK
  require_once __DIR__ . '/../CafeteriaApp.Backend/lib/vendor/autoload.php';

  // Include required libraries
  use Facebook\Facebook;
  use Facebook\Exceptions\FacebookResponseException;
  use Facebook\Exceptions\FacebookSDKException;

  /*
   * Configuration and setup Facebook SDK
   */
  $appId         = '139373683321383'; //Facebook App ID
  $appSecret     = 'a38d8ec36e0338c2e36620d54ae75a7b'; //Facebook App Secret
  $redirectURL   = urldecode('http://localhost/CafeteriaApp/CafeteriaApp.Frontend/'); //Callback URL
  $fbPermissions = array('email');  //Optional permissions

  $fb = new Facebook(array(
      'app_id' => $appId,
      'app_secret' => $appSecret,
      'default_graph_version' => 'v2.2',
      'persistent_data_handler'=>'session'
  ));

  // Get redirect login helper


  $helper = $fb->getRedirectLoginHelper();

  // Try to get access token

    try {
      if ( isset($_SESSION['facebook_access_token']) ) {
        $accessToken = $_SESSION['facebook_access_token'];
      }
      else {
        $accessToken = $helper->getAccessToken();
      }
    }
    catch(FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    }
    catch(FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
    // echo $_SESSION['FBRLH_state'];
      // echo $_GET['state'];
      //  echo "\r\n";
      //     echo $e->getCode();
      //     echo "\r\n";
      //     echo $e->getFile();
      //       echo "\r\n";
      //     echo $e->getLine();
      //   echo "\r\n";
    //     echo $e->getTraceAsString();  
    //echo "<pre>";
        //print_r($e->getTrace()) ; 
        //echo "</pre>";
        exit;
  }
?>