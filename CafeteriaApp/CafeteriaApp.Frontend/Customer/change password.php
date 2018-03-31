<?php
	require(__DIR__.'/../../CafeteriaApp.Backend/session.php'); // must be first as it uses cookies 
	require(__DIR__.'/../../CafeteriaApp.Backend/Controllers/User.php');
	require(__DIR__.'/../../CafeteriaApp.Backend/validation_functions.php'); 

if ( isset( $_POST['submit']) ) {
	$required_fields = array('oldPass', 'newPass','confirmPass');
  	validate_presences($required_fields);

	if ( empty($errors) ) {}

	if ($_POST['newPass'] !== $_POST['confirmPass'] ) {
		echo "<h3 class=\"error\">The new password must match the confirm one !</h3>";
	}
	else {
		if ( isset($_SESSION['UserId']) ) {
			$hashed = password_encrypt($_POST['confirmPass']);
			updateUserPasswordById($conn, $hashed, $_SESSION['UserId']);
			echo "<h3 style=\"color:blue;\">The password  updated successfully !</h3>";
		}
		else {
			$_SESSION['message'] = "<h3 class=\"error\">You must be logged in first !</h3>";
			redirect_to('../../Views/login.php');
		}
	}
}	
?>

<link href="../css/errors.css" rel="stylesheet" type="text/css">

<div>

	<p><?php echo form_errors($errors); ?></p>
   
	<form action="change password.php" method="post" style="align-content: center;text-align: center">

		<table align="center">

			<tr>

				<td>Old Password :</td>

				<td>

					<input type="password" name="oldPass">

				</td>

			</tr>

			<tr>

				<td>New Password :</td>

				<td>

					<input type="password" name="newPass">

				</td>

			</tr>

			<tr>

				<td>New Password :</td>

				<td>

					<input type="password" name="confirmPass">

				</td>

			</tr>

			<tr>

				<td>

					<input type="submit" name="submit" value="Change">

				</td>

			</tr>

		</table>

	</form>
	
</div>