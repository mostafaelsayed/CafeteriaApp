<?php 
	require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/User.php');
	require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/PHPMailer/PHPMailerAutoload.php');
	//require_once("CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/PHPMailer/Language/phpmailer.lang-en.php");

	if ( isset($_POST['submit']) ) {
		if ( isset($_POST['mail']) ) {
			//echo $_POST['mail'];
			if ( !empty($_POST['mail']) ) {
				// send new password and store the hashed one
				if ( checkExistingEmail($conn, $_POST['mail']) ) {
					$pass =	randomPassword();
					$hashed = password_encrypt($pass);
					updateUserPasswordByEmail($conn, $hashed, $_POST['mail']);
					// send the new password and store its hash
					$mail = new PHPMailer();

					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'mmhnabawy@gmail.com';                 // SMTP username
					$mail->Password = 'mmhnabawy';                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;                                    // TCP port to connect to
					$mail->setFrom('mm_h424@yahoo.com', 'Cafetria App');
					$mail->addAddress($_POST['mail'],"");
					$mail->Subject = "Cafetria App Reset Password";
					$mail->Body = "your new password is : " . $pass;
				
					$result = $mail->Send();

					if ($result) {
						redirect_to('login.php'); 
					}
					else {
						echo "Error Occured while sending the new password !";
					}

					//echo $result? 'sent':'error'
				}
				else {
					echo "Email doesn't exist !";
				}
			}
			else {
				echo "<h2 style='color: red'>Email can't be blank !</h2> ";
			}
		}
	}
?>

<div style="align-content: center;text-align: center">

	<form action="resetPassword.php" method="post">

		<div>

			<label for="input"> Enter your email :</label>

			<input id="input" type="text" name="mail" placeholder="example@cafetria.com" />

		</div>

		<br>

		<div>

			<input type="submit" name="submit" value="Reset Password">

		</div>	

	</form>

</div>