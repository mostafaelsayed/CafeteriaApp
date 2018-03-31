<!DOCTYPE html>

<html>

  <head>

    <title>Register Form</title>

    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/icon.png">

    <link rel="icon" type="text/css" href="../../favicon.ico">

    <link rel="stylesheet" type="text/css" href="css/materialize.css"/>

    <link rel="stylesheet" type="text/css" href="icons/icons.css"/>

    <link href="../css/input_file.css" rel="stylesheet">

    <link href="../css/errors.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="css/register.css">

    <script src="js/jquery-3.1.1.min.js"></script>

    <script src="js/materialize.js"></script>

    <script src="js/newjavascript.js"></script>

    <script src="../javascript/angular.min.js"></script>

    <script src="../javascript/angular-route.js"></script>

    <script src="../javascript/ui-bootstrap-2.5.0.js"></script>

    <script src="../javascript/ui-bootstrap-tpls-2.5.0.js"></script>

    <script src="../javascript/angular-modal-service.js"></script>

    <script src= "register.js"></script>

    <script src="../javascript/alertify.js"></script>

  </head>

<style type="text/css">

  * {

    color: violet

  }

  [ng\:cloak], [ng-cloak], .ng-cloak {

    display: none !important

  }

</style>

  <body ng-app="register" >

    <div id="main">

      <div id="navigation">

        &nbsp;

      </div>
      
      <h2 style="text-align: center"> New User </h2>

      <div class="row" ng-controller="Register">  

        <form novalidate role="form" name="myform" style="width: 40%;margin: auto;text-align: center">
     
          <div class="input-field col s12">

            <label for="un">User Name</label>

            <input id="un" type="text" name="userName" ng-model="userName" style="text-align: center" ng-maxlength="30" ng-required />

            <span ng-cloak ng-show="myform.name.$touched && myform.userName.$invalid">User Name is required.</span>

            <span ng-cloak ng-show="myform.name.$touched && myform.userName.$invalid">User Name must be less than 30 character or numbers .</span>

          </div>

          <div class="input-field col s12">

            <label for="ps">Password</label>

            <input id="ps" type="password" name="password" ng-model="password" style="text-align: center" required />

            <span ng-cloak ng-show=" myform.name.$touched && myform.password.$invalid">Password is required.</span>

          </div>

          <div class="input-field col s12">

            <label for="fn">First Name</label>

            <input id="fn" type="text" name="firstName" ng-model="firstName" style="text-align: center" required />

            <span ng-cloak ng-show="myform.name.$touched && myform.firstName.$invalid">First Name is required.</span>

          </div>

          <div class="input-field col s12">

            <label for="ln">Last Name</label>

            <input id="ln" type="text" name="lastName" ng-model="lastName" style="text-align: center" required />

            <span ng-cloak ng-show="myform.name.$touched && myform.lastName.$invalid">Last Name is required.</span>

            <div><br><br></div>

          </div>

          <label class="labels" style="font-size: 16px">Gender</label><br>

          <br>

          <input class="with-gap" name="gender" ng-model="gender" type="radio" id="male" value="1" required />

          <label for="male">Male</label>

          <br>

          <input class="with-gap" name="gender" ng-model="gender" type="radio" id="female" value="2" required/>

          <label for="female" style="margin-right: -16px">Female</label>

          <br>

          <input class="with-gap" name="gender" ng-model="gender" type="radio" id="other" value="3" required />

          <label for="other" style="margin-right: -5px">Other</label>

          <h3 ng-cloak ng-show="myform.gender.$touched && myform.gender.$invalid">Gender is required.</h3>

          <br><br>

          <div class="input-field col s12">

            <label for="em">E-mail</label>

            <input id="em" type="text" name="email" ng-model="email" style="text-align: center" required/>

            <span id="emailConfirm" ng-cloak ng-show="myform.name.$touched && myform.email.$invalid">Email is required.</span>

          </div>

          <div class="input-field col s12">

            <label for="pn">Phone Number</label>

            <input id="pn" type="text" name="phone" ng-model="phone" style="text-align: center" required />

            <span ng-cloak ng-show="myform.name.$touched && myform.phone.$invalid">Phone Number is required.</span>

          </div>

          <div class="input-field col s12">

            <input id="DOB" name="DOB" type="date" class="datepicker" ng-model="DOB" required />

            <span ng-cloak ng-show="myform.name.$touched && myform.DOB.$invalid">Date of Birth is required.</span>

            <label for="DOB">Date of Birth</label>

          </div>

          <div class="input-field col s12">
      
            <div class="dropzone" file-dropzone="[image/png, image/jpeg]" file="image" file-name="imageFileName" data-max-file-size="3">
          
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

          <input type="submit" name="cancel" class="btn btn-primary" value="Reset" id="cancel" ng-click="cancel()"/>
            
        </form>

      </div>

      <br>
      
    </div>

  </body>

</html>