<?php
    // Include FB config file && User class
    require(__DIR__ . '/../CafeteriaApp.Backend/Controllers/Notification.php'); 
    require(__DIR__ . '/fbConfig.php');
    require(__DIR__ . '/fbUser.php');

    if (isset($accessToken) ) {
        
        if ( isset($_SESSION['facebook_access_token']) ) {
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
        else {
            // Put short-lived access token in session
            $_SESSION['facebook_access_token'] = (string) $accessToken;
            
              // OAuth 2.0 client handler helps to manage access tokens
            $oAuth2Client = $fb->getOAuth2Client();
            
            // Exchanges a short-lived access token for a long-lived one
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
            $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
            
            // Set default access token to be used in script
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
        

        // Redirect the user back to the same page if url has "code" parameter in query string
        /* if(isset($_GET['code'])){
            header('Location: ./');
        }*/
        

        // Getting user facebook profile info
        try {
            $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture,birthday');
            $fbUserProfile = $profileRequest->getGraphNode()->asArray();
        } 
        catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // Redirect user back to app login page
            header("Location: ./");
            exit;
        } 
        catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            echo "\r\n";
            echo $e->getCode();
            echo "\r\n";
            echo $e->getFile();
            echo "\r\n";
            echo $e->getLine();
            exit;
        }
        
        // Initialize User class
        //echo "string";
        $user = new User();
        
        // Insert or update user data to the database
        $fbUserData = array(
            'oauth_provider'=> 1, //id of facebook in auth_provider table
            'oauth_uid'     => $fbUserProfile['id'],
            'first_name'    => $fbUserProfile['first_name'],
            'last_name'     => $fbUserProfile['last_name'],
            'email'         => $fbUserProfile['email'],
            'gender'        => $fbUserProfile['gender'],
            'locale'        => $fbUserProfile['locale'],
            'picture'       => $fbUserProfile['picture']['url'],
            'link'          => $fbUserProfile['link'],
            'birthday'      => $fbUserProfile['birthday']
        );

        $userData = $user->checkUser($fbUserData);
        
        // Put user data into session
        // $_SESSION['userData'] = $userData;
        $_SESSION['userId'] = $userData['Id'];
        $_SESSION['userName'] = $userData['UserName'];
        $_SESSION['roleId'] = $userData['RoleId'];
        $_SESSION['langId'] = $userData['LocaleId'];
        $_SESSION['notifications']= $userData["notifyme"];
        // Get logout url
        $logoutURL = $helper->getLogoutUrl($accessToken ,'fblogout.php');
        
        // Render facebook profile data
        if ( !empty($userData) ) {
            // print_r($_SESSION['userData']);
            // $output  = '<h1>Facebook Profile Details </h1>';
            // $output .= '<img src="'.$userData['Picture'].'">';
            // $output .= '<br/>Facebook ID : ' . $userData['Auth_Provider_UserId
            // $output .= '<br/>Name : ' . $userData['FirstName'].' '.$userData['LastName'];
            // $output .= '<br/>Email : ' . $userData['Email'];
            // $output .= '<br/>Gender : ' . $userData['GenderId'];
            // $output .= '<br/>Locale : ' . $userData['LocaleId'];
            // $output .= '<br/>Logged in with : Facebook';
            // $output .= '<br/><a href="'.$userData['Link'].'" target="_blank">Click to Visit Facebook Page</a>';

            // $output .= '<br/>Logout from <a href="'.$logoutURL.'">Facebook</a>'; 
            header("Location:/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/categories.php");
        }
        else {
            $output = '<h3 style="color: red">Some problem occurred, please try again.</h3>';
        }
    }
    else {
        // Get login url
        // Render facebook login button
        $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
        header( "Location:" . ($loginURL) );     
    }
?>