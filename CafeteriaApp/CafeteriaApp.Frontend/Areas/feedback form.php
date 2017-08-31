<!-- like ads ,but hide what's in back , capatcha -->
<?php 

if(isset($_POST['submit']))
if(isset($_POST['check']))
{

	 if($_POST['check']=== $_POST['sum'])//success
	 {
	 	echo "success hhhhhhhhhhhh";
	 }

}
else
{


}


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
		<!-- <link rel="stylesheet" type="text/css" href="/CafeteriaApp.Frontend/css/normalize.css"> -->
	<link rel="stylesheet" type="text/css" href="/CafeteriaApp.Frontend/css/feedback.css">
</head>
<body >
<div>
<div id="feedbackForm"> 
<form method="post" action="feedback form.php">

	<div class="entry">
	<label for="name">Name:</label>
	<input type="text" id="name" required>
	</div>

	<div class="entry">
	<label for="mail">Email:</label>
	<input type="mail" id="mail" required>
	</div>

	<div class="entry">
	<label for="phone">Phone:</label>
	<input type="text" id="phone" required>
	</div>

	<div class="entry"> 
	<label for="about">About:</label>
	<select id="about" ></select> 
	</div>
	
	<div class="entry">
		<h4 style="margin: 0px;padding-left: 50px;"> <?php $x = rand(0,20);echo $x ; ?>+<?php $y = rand(0,20); echo $y ;?> =</h4>
	<label for="check" style="float:left;">	Answer:</label>
	<input type="text" id="check" name="check" required>
	 <input type="hidden" name="sum" value="<?php echo $y + $x; ?>">

	</div>

	<div class="entry">
	<label for="message" style="float: left;" >Message:</label>
	<textarea id="message" required></textarea>
	</div>

	<input type="submit" id="submitbtn" value="Submit" name="submit" style="height: 30px;width: 100px;color:white;background-color: #7FC27F;font-weight: bold;margin-left: 30px; ">
</form>

</div>
</div>

</body>
</html>