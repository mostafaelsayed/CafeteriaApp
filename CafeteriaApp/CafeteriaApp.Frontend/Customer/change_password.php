<?php

ob_start();
require __DIR__ . '/../layout.php'; // must be first as it uses cookies
validatePageAccess([2]);
require __DIR__ . '/../../CafeteriaApp.Backend/Controllers/User.php';
require __DIR__ . '/../../CafeteriaApp.Backend/validation_functions.php';

if (isset($_POST['submit'])) {
    $required_fields = array('oldPass', 'newPass', 'confirmPass');
    validate_presences($required_fields);

    if (empty($errors)) {

        if ($_POST['newPass'] !== $_POST['confirmPass']) {
            echo "<h3 class=\"error\">The new password must match the confirm one !</h3>";
        } else {

            if (isset($_SESSION['userId'])) {
                $hashed = password_encrypt($_POST['confirmPass']);
                if(updateUserPasswordById($conn, $hashed, $_SESSION['userId']))
                	 $_SESSION['message'] =  "<h3 style=\"color:green;\">The password updated successfully !</h3>";
            } else {
                $_SESSION['message'] = "<h3 class=\"error\">You must be logged in first !</h3>";
                redirect_to( __DIR__ .'/../login.php');
            }
        }

    }
}
?>

<link href="../css/errors.css" rel="stylesheet" type="text/css">

<style type="text/css">
input[type="password"]{
	text-align:center;
}	
</style>
<div>
	
	<br><br><br><br><br><br><br><br>
	<p><?= form_errors($errors); ?></p>
	<?= message(); ?>
	<form action="change_password.php" method="post" style="text-align:center;width:50%; color:white;margin:0 auto;">
		<h1>Change Password</h1>

			<div class="form-group">
				<h4 class="col-md-6">Old Password </h4>
				<input class="form-control col-md-6" type="password" name="oldPass">
			</div>

			<div class="form-group">
				<h4 class="col-md-6">New Password </h4>
				<input class="form-control" type="password" name="newPass">
			

			<div class="form-group">
				<h4 class="col-md-6">Confirm one </h4>
				<input class="form-control" type="password" name="confirmPass">
			</div>
			<div class="form-group">
				<input class="btn btn-warning" type="submit" name="submit" value="Change password">
			</div>


	</form>
</div>