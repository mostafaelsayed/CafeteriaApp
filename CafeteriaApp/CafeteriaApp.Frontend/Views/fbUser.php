<?php
class User {
    private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName     = "mydb";
    
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
            $prevQuery = "SELECT User.Id , User.UserName , User.RoleId , User.LocaleId  FROM ThirdPartyUser inner join User on User.Id = ThirdPartyUser.UserId   WHERE Auth_ProviderId = '".$userData['oauth_provider']."' AND  Auth_Provider_UserId = '".$userData['oauth_uid']."'";
            $prevResult = $this->db->query($prevQuery);

            if($prevResult->num_rows > 0){
                // Update user data if already exists
                $query = "UPDATE ThirdPartyUser SET  Link = '".$userData['link']."', Modified = '".date("Y-m-d H:i:s")."' WHERE Auth_ProviderId = '".$userData['oauth_provider']."' AND Auth_Provider_UserId = '".$userData['oauth_uid']."'";
                $update = $this->db->query($query);

                //  $query = "UPDATE User SET FirstName = '".$userData['first_name']."', LastName = '".$userData['last_name']."' , UserName ='". $userData['first_name']."_".$userData['last_name'] ."',LocaleId = (select Id from Locale where Name ='".$userData['locale']."' ) , Image= '".$userData['picture']."'  WHERE UserId = '".$userData['oauth_uid']."'";
                // $update = $this->db->query($query);


            }
            else
            {
                //Insert user data into User Table
                $passwordHash=""; 
                $phoneNumber="empty";
                $roleId=2;
                $query = "INSERT INTO User SET  FirstName = '".$userData['first_name']."', LastName = '".$userData['last_name']."',UserName ='". $userData['first_name']."_".$userData['last_name'] ."' , Email = '".$userData['email']."' , LocaleId = (select Id from Locale where Name ='".$userData['locale']."' ) , Image = '".$userData['picture']."' , PasswordHash='".$passwordHash."' , PhoneNumber='".$phoneNumber."' , RoleId='".$roleId."'";

                      $insert = $this->db->query($query);
                    $userId=mysqli_insert_id($this->db);


               //Insert user data into ThirdPartyUser Table
                $query = "INSERT INTO ThirdPartyUser SET Auth_ProviderId = '".$userData['oauth_provider']."', Auth_Provider_UserId = '".$userData['oauth_uid']."', Link = '".$userData['link']."', Created = '".date("Y-m-d H:i:s")."', Modified = '".date("Y-m-d H:i:s")."'  , UserId='".$userId ."' ";
                $insert = $this->db->query($query);

               
                //Insert user data into Customer Table
                $dateOfBirth='1900-08-01';
              $query = "INSERT INTO Customer SET Credit = '0.0' , UserId='".$userId."' , DateOfBirth='". $dateOfBirth ."', GenderId = (select Id from Gender where LCASE(Name) ='".$userData['gender']."')  ";
                $insert = $this->db->query($query);

            }
            

            // Get user data from the database
            $result = $this->db->query($prevQuery);
            $userData = $result->fetch_assoc();
        $userData["notifyme"]= getNotificationByUserId( $this->db , $_SESSION["userId"] );// if not found

        }
        
        // Return user data
        return $userData;
    }
}
?>