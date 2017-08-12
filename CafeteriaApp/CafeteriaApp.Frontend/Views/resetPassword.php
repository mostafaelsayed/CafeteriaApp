<?php 
 require_once("CafeteriaApp.Backend/functions.php");
require_once( 'CafeteriaApp.Backend/Controllers/User.php');
require_once("CafeteriaApp.Frontend/Views/PHPMailer/class.phpmailer.php");
require_once("CafeteriaApp.Frontend/Views/PHPMailer/class.smtp.php");
//require_once("CafeteriaApp.Frontend/Views/PHPMailer/Language/phpmailer.lang-en.php");


if(isset($_POST['submit']))
{
if(isset($_POST['mail']))
{
	//echo $_POST['mail'];
	if(!empty($_POST['mail']) )
	{
	//	send new password and store the hashed one
	if(checkExistingEmail($conn,$_POST['mail']))
		{
		$pass =	randomPassword();
		$hashed =password_encrypt($pass);
		updateUserPassword($conn,$hashed,$_POST['mail']);
			//send the new password and store its hash

		$mail =new PHPMailer();
		$mail->FromName = "Cafetria App";
		$mail->From = "mm_h424@yahoo.com";
		$mail->AddAddress($_POST['mail'],"");
		$mail->Subject= "Cafetria App Reset Password";
		$mail->Body = "your new password is : ".$pass;
		
		$result =$mail->Send();

		if($result)
		{
			redirect_to('/CafeteriaApp.Frontend/Views/login.php'); 
		}
		else
		{echo "Error Occured while sending the new password !";

		}
		//echo $result? 'sent':'error'
	}
	else
	{
		echo "Email doesn't exist !";
	}
	}
	else
	{
		echo "<h2 style='color:red;'> Email can't be blank !</h2> ";
	}
		
}
}

?>

<div style="align-content: center;text-align: center;">
<form action="resetPassword.php" method="post" >
<div>
<label for="input"> Enter your email :</label>
<input id="input" type="text" name="mail" placeholder="example@cafetria.com">
</div>
<br>
<div>
<input type="submit" name="submit" value="Reset Password" >
</div>	

</form>
</div>