<?php require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies 
 require_once("CafeteriaApp.Backend/functions.php"); 
 require_once("CafeteriaApp.Backend/validation_functions.php"); 
 //require_once("CafeteriaApp.Frontend/Views/register2.php");?>

<head>
    
        <title>Register Form</title>
        <link rel="icon" href="images/icon.png">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
      <link rel="stylesheet" type="text/css" href="css/materialize.css"/>
        <!-- <link rel="stylesheet" type="text/css" href="css/style.css"/> -->
        <link rel="stylesheet" type="text/css" href="icons/icons.css"/>
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/materialize.js"></script>
        <script src="js/newjavascript.js"></script>
    

        <!-- <link href='https://fonts.google.com/?category=Serif,Sans+Serif,Monospace&selection.family=Roboto+Slab' rel='stylesheet'> -->
        <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
  <script src="/CafeteriaApp.Frontend/javascript/jquery-3.2.1.min.js"></script>

        <script src="/CafeteriaApp.Frontend/javascript/angular.min.js"></script>
        <!-- <script src= "/CafeteriaApp.Frontend/Scripts/myapp.js"></script> -->
        <script src= "/CafeteriaApp.Frontend/Views/register.js"></script>
      <link href="/CafeteriaApp.Frontend/css/errors.css" rel="stylesheet" type="text/css">
        <script src="/CafeteriaApp.Frontend/javascript/alertify.min.js"></script>


    </head>
    <body>
<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page" class="row" style="align-content:center; text-align:center;" >
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2> New User </h2>
          <center> 
     <div class="row"  ng-app="myapp" ng-controller="Register">  

    <form  novalidate    name="myForm" class="col s12"   method="post" style="align-content:center;text-align:center;width:70%;">
 

      <div class="input-field col s12"  >
      <label  for="un">User Name</label>
        <input id="un" type="text" name="userName" ng-model="userName"  ng-maxlength="30" maxlength="30"  required/>
        <span  ng-show=" myForm.$submitted && myForm.userName.$invalid || myForm.userName.length>30 " >User Name is required.</span>
      </div>

       <div class="input-field col s12" >
       <label  for="ps">Password</label>
        <input id="ps" type="password" name="password" ng-model="password"   required/>
        <span  ng-show=" myForm.$submitted && myForm.password.$invalid" >Password is required.</span>

      </div >


      <div class="input-field col s12" >    
        <label  for="fn">First Name</label>
        <input id="fn" type="text" name="firstName"  ng-model="firstName"  required/>
      <span  ng-show=" myForm.$submitted && myForm.firstName.$invalid" >First Name is required.</span>

      </div>

      <div class="input-field col s12">
      <label  for="ln">Last Name</label>
        <input id="ln" type="text" name="lastName" ng-model="lastName"   required/>
      <span  ng-show=" myForm.$submitted && myForm.lastName.$invalid" >Last Name is required.</span>

      </div>
        <br>
                    <label class="labels">Gender</label><br>
                    <br>
                    <input class="with-gap" name="gender" ng-model="gender" type="radio" id="male" value="1" />
                    <label for="male">Male</label>
                    <br>
                    <input class="with-gap" name="gender" ng-model="gender" type="radio" id="female" value="2"  />
                    <label for="female">Female</label>
                    <br>
                    <input class="with-gap" name="gender" ng-model="gender" type="radio" id="other" value="3"  />
                    <label for="other">Other</label>
                    <br><br>
             
                    <div class="input-field col s12">


      <div class="input-field col s12">
        <label  for="em">E-mail</label>

        <input id="em" type="text" name="email"  ng-model="email"   required/>
        <span id="emailConfirm" ng-show=" myForm.$submitted && myForm.email.$invalid" >Email is required.</span>

      </div>

      <div class="input-field col s12">
        <label  for="pn">Phone Number</label>
        <input id="pn" type="text" name="phone" ng-model="phone"  required/>
   <span  ng-show=" myForm.$submitted && myForm.phone.$invalid" >Phone Number is required.</span>

      </div>

      <div class="input-field col s12" >
        <i class="material-icons prefix">today</i>
        <input id="DOB" name="DOB" type="date" class="datepicker" ng-model="DOB" style="width:70%" required>
        <span  ng-show=" myForm.$submitted && myForm.DOB.$invalid" >Date of Birth is required.</span>
        <label for="DOB">Select your Date of Birth</label>
        </div>

      <div class="input-field col s12">
      Image
        <input type="file" ng-model="image"  name="upload" id="personalImg" />
        <div id="error-div">
          <p id="view-err"> </p>
        </div>
        <!-- <input type="text" name="image" ng-model="image"  /> -->
     <!-- <span  ng-show=" myForm.$submitted && myForm.image.$invalid" >Image is required.</span> -->

        </div>
     
      <input id="save" type="submit" name="submit" value="Next" ng-click="registerfn()" />
        
        </form>
      
 </div>
    </center>
   <input type="submit" name="cancel" value="Cancel" />
    <br />
    
  </div>
</div>
</body>
<?php //ng-disabled="myForm.userName.$invalid||myForm.password.$invalid||myForm.firstName.$invalid||myForm.lastName.$invalid" 
//include("../includes/layouts/footer.php"); ?>
 <script>
        $(function(){
            $("#save").click(function () {
                // 1- check if it's empty
                //if ($("#personalImg").val() == "") {
                //    $("#error-div").fadeIn();
                //    $("#view-err").append("Please, Choose an image for the job !");
                //    return false;
                //}

                //2- check  image extension is valid
                if ($("#personalImg").val() != "") {

                    var filename = document.getElementById("personalImg").value;
                    var extension = filename.substr(filename.lastIndexOf('.') + 1);
                    var validExtensions = ['jpeg', 'png', 'gif', 'bmp']; // like a list
                    if ($.inArray(extension, validExtensions) == -1) {
                        $("#error-div").fadeIn();
                        $("#view-err").append("Please, Choose a valid image for the job !");
                        return false;//no save or no redirect
                    }

                    //3-check image size
                    var fileSize = document.getElementById("personalImg").files[0].size / 1024 / 1024;//to get the size in megabytes
                    if (fileSize > 2) {
                        $("#error-div").fadeIn();
                        $("#view-err").append("Please, Choose a smaler image for the job !");
                        return false;
                    }
                }

            });
        });

    </script>