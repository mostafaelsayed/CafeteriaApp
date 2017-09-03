<!DOCTYPE html>

<html>

  <head>

    <title>Register Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" type="text/css" href="css/materialize.css"/>
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"/> -->
    <link rel="stylesheet" type="text/css" href="icons/icons.css"/>
    <link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">
    <link href="/CafeteriaApp.Frontend/css/errors.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/register.css">

    <!-- <link href='https://fonts.google.com/?category=Serif,Sans+Serif,Monospace&selection.family=Roboto+Slab' rel='stylesheet'> -->
    <!-- <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'> -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/materialize.js"></script>
    <script src="js/newjavascript.js"></script>
    <script src="/CafeteriaApp.Frontend/javascript/angular.min.js"></script>
    <script src="/CafeteriaApp.Frontend/javascript/angular-route.js"></script>
    <script src="/CafeteriaApp.Frontend/javascript/ui-bootstrap-2.5.0.js"></script>
    <script src="/CafeteriaApp.Frontend/javascript/ui-bootstrap-tpls-2.5.0.js"></script>
    <script src="/CafeteriaApp.Frontend/javascript/angular-modal-service.js"></script>
    <script src="/CafeteriaApp.Frontend/javascript/myapp.js"></script>
    <script src= "/CafeteriaApp.Frontend/Views/register.js"></script>
    <script src="/CafeteriaApp.Frontend/javascript/alertify.min.js"></script>
  </head>

  <body ng-app="register" >

    <div id="main">

      <div id="navigation">

        &nbsp;

      </div>

      <div id="page" class="row" style="align-content:center;text-align:center">

        <?php// echo message(); ?>

        <?php //echo form_errors($errors); ?>

      </div>
      
      <h2 style="text-align: center;color: white"> New User </h2>

      <div class="row" ng-controller="Register">  

        <!-- enctype="multipart/form-data" -->

      <form novalidate role="form" name="myform" style="width:40%;margin:auto;text-align:center">
   
          <div class="input-field col s12">

            <label for="un">User Name</label>

            <input id="un" type="text" name="userName" ng-model="userName" style="text-align: center;color: white" ng-maxlength="30" ng-required ="dddd"/>

            <span ng-show=" myform.$submitted && myform.userName.$invalid">User Name is required.</span>

            <span ng-show=" myform.userName.$invalid">User Name must be less than 30 character or numbers .</span>

          </div>

          <div class="input-field col s12">

            <label for="ps">Password</label>

            <input id="ps" type="password" name="password" ng-model="password" style="text-align: center;color: white" required/>

            <span ng-show=" myform.$submitted && myform.password.$invalid">Password is required.</span>

          </div>

          <div class="input-field col s12">

            <label for="fn">First Name</label>

            <input id="fn" type="text" name="firstName" ng-model="firstName" style="text-align: center;color: white" required/>

            <span ng-show="myform.$submitted && myform.firstName.$invalid">First Name is required.</span>

          </div>

          <div class="input-field col s12">

            <label for="ln">Last Name</label>

            <input id="ln" type="text" name="lastName" ng-model="lastName" style="text-align: center;color: white" required/>

            <span ng-show=" myform.$submitted && myform.lastName.$invalid" >Last Name is required.</span>

            <div><br><br></div>

          </div>

          <label class="labels" style="font-size: 16px">Gender</label><br>

          <br>

          <input class="with-gap" name="gender" ng-model="gender" type="radio" id="male" value="1" />

          <label for="male">Male</label>

          <br>

          <input class="with-gap" name="gender" ng-model="gender" type="radio" id="female" value="2" />

          <label for="female" style="margin-right: -16px">Female</label>

          <br>

          <input class="with-gap" name="gender" ng-model="gender" type="radio" id="other" value="3" />

          <label for="other" style="margin-right: -5px">Other</label>

          <br><br>

          <div class="input-field col s12">

            <label for="em">E-mail</label>

            <input id="em" type="text" name="email" ng-model="email" style="text-align: center;color: white" required/>

            <span id="emailConfirm" ng-show=" myform.$submitted && myform.email.$invalid" >Email is required.</span>

          </div>

          <div class="input-field col s12">

            <label for="pn">Phone Number</label>

            <input id="pn" type="text" name="phone" ng-model="phone" style="text-align: center;color: white" required />

            <span ng-show=" myform.$submitted && myform.phone.$invalid" >Phone Number is required.</span>

          </div>

          <div class="input-field col s12">

            <!-- <i class="material-icons prefix">today</i> -->

            <input id="DOB" name="DOB" type="date" class="datepicker" style="color: white" ng-model="DOB" required />

            <span ng-show="myform.$submitted && myform.DOB.$invalid">Date of Birth is required.</span>

            <label for="DOB">Date of Birth</label>

          </div>

          <div class="input-field col s12">
      
            <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name="imageFileName" data-max-file-size="3">
          
              <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">

              <img ng-src="{{uploadme.src}}" width="200" height="200" id="profileImage">

              <div><br></div>

            </div>

            <div>

              <button class="btn btn-primary" onclick="mylabel.click()">Choose image</button>

              <label id="mylabel" for="file"></label>

              <div><br><br><br></div>

            </div>

          </div>
       
          <input id="save" type="submit" class="btn btn-primary" name="submit" value="Next" ng-click="registerfn()" />

          <input type="submit" name="cancel" class="btn btn-primary" value="Cancel" id="cancel" ng-click="cancel()"/>
          
        </form>

      </div>

      <br>
      
    </div>

  </body>

</html>



<?php //ng-disabled="myform.userName.$invalid||myform.password.$invalid||myform.firstName.$invalid||myform.lastName.$invalid" 
//include("../includes/layouts/footer.php");
        // $(function(){
        //     $("#save").click(function () {
        //         // 1- check if it's empty
        //         //if ($("#personalImg").val() == "") {
        //         //    $("#error-div").fadeIn();
        //         //    $("#view-err").append("Please, Choose an image for the job !");
        //         //    return false;
        //         //}

        //         //2- check  image extension is valid
        //         if ($("#personalImg").val() != "") {

        //             var filename = document.getElementById("personalImg").value;
        //             var extension = filename.substr(filename.lastIndexOf('.') + 1);
        //             var validExtensions = ['jpeg', 'png', 'gif', 'bmp']; // like a list
        //             if ($.inArray(extension, validExtensions) == -1) {
        //                 $("#error-div").fadeIn();
        //                 $("#view-err").append("Please, Choose a valid image for the job !");
        //                 return false;//no save or no redirect
        //             }

        //             //3-check image size
        //             var fileSize = document.getElementById("personalImg").files[0].size / 1024 / 1024;//to get the size in megabytes
        //             if (fileSize > 2) {
        //                 $("#error-div").fadeIn();
        //                 $("#view-err").append("Please, Choose a smaler image for the job !");
        //                 return false;
        //             }
        //         }

        //     });
        // });

 ?>