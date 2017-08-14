<?php
class User {
    private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName     = "mydb";
    private $userTbl    = 'facebookuser';
    
    function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
    
    function checkUser($userData = array()){
        if(!empty($userData)){
            // Check whether user data already exists in database
            $prevQuery = "SELECT * FROM ".$this->userTbl." WHERE Auth_ProviderId = '".$userData['oauth_provider']."' AND  Auth_Provider_UserId = '".$userData['oauth_uid']."'";
            $prevResult = $this->db->query($prevQuery);

            if($prevResult->num_rows > 0){
                // Update user data if already exists
                $query = "UPDATE ".$this->userTbl." SET FirstName = '".$userData['first_name']."', LastName = '".$userData['last_name']."', Email = '".$userData['email']."', GenderId = (select Id from Gender where LCASE(Name) ='".$userData['gender']."') , LocaleId = (select Id from Locale where Name ='".$userData['locale']."' ) , ImageLink= '".$userData['picture']."', Link = '".$userData['link']."', Modified = '".date("Y-m-d H:i:s")."' WHERE Auth_ProviderId = '".$userData['oauth_provider']."' AND Auth_Provider_UserId = '".$userData['oauth_uid']."'";
                $update = $this->db->query($query);
            }
            else
            {
                // Insert user data
                $query = "INSERT INTO ".$this->userTbl." SET Auth_ProviderId = '".$userData['oauth_provider']."', Auth_Provider_UserId = '".$userData['oauth_uid']."', FirstName = '".$userData['first_name']."', LastName = '".$userData['last_name']."',UserName ='". $userData['first_name']."_".$userData['last_name'] ."' , Email = '".$userData['email']."', GenderId = (select Id from Gender where LCASE(Name) ='".$userData['gender']."') , LocaleId = (select Id from Locale where Name ='".$userData['locale']."' ) , ImageLink = '".$userData['picture']."', Link = '".$userData['link']."',Credit = 0.0 , Created = '".date("Y-m-d H:i:s")."', Modified = '".date("Y-m-d H:i:s")."'";
                $insert = $this->db->query($query);
            }
            
            // Get user data from the database
            $result = $this->db->query($prevQuery);
            $userData = $result->fetch_assoc();
        }
        
        // Return user data
        return $userData;
    }
}
?>