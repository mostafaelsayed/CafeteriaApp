<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Health Prediction App</title>
        <link rel="icon" href="images/icon.png">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
      <link rel="stylesheet" type="text/css" href="css/materialize.css"/>
        <!-- <link rel="stylesheet" type="text/css" href="css/style.css"/> -->
        <link rel="stylesheet" type="text/css" href="icons/icons.css"/>
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/materialize.js"></script>
        <script src="js/newjavascript.js"></script>
    </head>
    <body>
        <div class="navbar-fixed">
          <nav>
            <div class="nav-wrapper">
              <a href="index.html" class="brand-logo"><img class="responsive-img" alt="header" src="images/Logo.png" /></a>
              <ul id="nav-mobile" class="right hide-on-med-and-down">
       
        <li><a href="aboutus.html">About Us</a></li>
        <li><a href="contactus.html">Contact Us</a></li>
         <li><a href="logout.php">Log Out</a></li>
              </ul>
              
            </div>
          </nav>
        </div>
        <?php
			
			$hostname = "localhost";
			$username = "root";
			$password = "";
			$databaseName = "graduationproject_schema";
			
			$connect = mysqli_connect($hostname, $username, $password, $databaseName);
			
			if(mysqli_connect_errno())
			{
				echo "Failed to connect: ".mysqli_connect_errno(); 
			}
			
		?>


    <div class="row">


    <form action="SearchPage.php" class="col s12" method="post">
        <div class="row">
    <div class="input-field col s12">

    <select name="regions">
      <option value="" disabled selected>Choose the region of the pain</option>
      <option value="1">General</option>
      <option value="2">Head</option>
      <option value="3">Hair</option>
      <option value="4">Ears</option>
      <option value="5">Orbital</option>
      <option value="6">Nasal</option>
      <option value="7">Oral</option>
      <option value="8">Neck</option>
      <option value="9">Buccal</option>
      <option value="10">Acromial</option>
      <option value="11">Axillary</option>
      <option value="12">Thoracic</option>
      <option value="13">Arms</option>
      <option value="14">Abdominal</option>
      <option value="15">Back</option>
      <option value="16">Legs</option>
      <option value="17">Femoral</option>
      <option value="18">Joints</option>
      <option value="19">Feet</option>
      <option value="20">Hands</option>
      <option value="21">Pubic</option>
      <option value="22">Skin</option>
      <option value="23">Mind</option>
      <option value="24">Blood</option>
      <option value="25">Respiratory device</option>
      <option value="26">Face</option>
      <option value="27">Vocal cords</option>
		  <?php
		   
			$region = $_POST['regions'];
			echo "selected value is " .$region;
			$query = "SELECT Symptom_Name FROM symptoms WHERE Body_area = '$region'" ;
			$result_symp = mysqli_query($connect, $query);
			
			
	  ?>
    </select>



	 <label>Choose the Region:</label>



	<input type="submit" name="submit" value="Search Symptoms" />

  </div>



            <?php
			if($_GET){
				if(isset($_GET['submit'])){
					submit();
				}
			}
			function submit()
				{
				echo "selected value is " .$region;
				$query = "SELECT Symptom_Name FROM symptoms WHERE Body_area = '$region'" ;
				$result_symp = mysqli_query($connect, $query);
				}
			?>

    <div class="input-field col s12">

    <select multiple name="symptoms[]">
      <option value="" disabled selected>Choose Symptom(s)</option>

	  <?php while($row1 = mysqli_fetch_array($result_symp)):;?>
      <option> <?php echo $row1[0];?></option>
	  <?php endwhile;?>

    </select>
    <label>Choose the Symptoms: </label>



	<input type="submit" name="add_symptoms" value="Add Symptoms" />
  <?php

			if(isset($_POST['add_symptoms']))
			{
					Diagnose();
			}
			
			function Diagnose()
			{
				if(is_array($_POST['symptoms']))
				{
					 foreach($_POST['symptoms'] as $selected_symptom) {
						$symp_data = "$selected_symptom,";
						$ret = file_put_contents('symptoms.txt', $symp_data, FILE_APPEND);
						if($ret === false) {
							die('There was an error writing this file');
						}
						else {
							echo "";
						}
					 }
					 echo "Your symptoms have been added.";
				}
			
			}
  ?>
	</div>
        </div>
		<a href="results.php">Diagnose!</a>

    </form>
    </div>
        
        
        
    </body>
</html>
