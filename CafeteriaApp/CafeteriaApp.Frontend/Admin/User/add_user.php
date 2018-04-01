<?php

require(__DIR__.'/../../../CafeteriaApp.Backend/functions.php');

validatePageAccess($conn);

require(__DIR__.'/../layout.php');
  
?>

<head>

  <title>Adding User</title>

  <meta name="viewport" content="width=device-width" />

  <link href="../../css/input_file.css" rel="stylesheet">

  <script src="../../js/angular-route.js"></script>

  <script src="../../js/image_module.js"></script>

  <script src="../../js/location_provider.js"></script>

  <script src="../../js/phone_number_module.js"></script>

  <script src="../../js/price_module.js"></script>

  <script src="../../js/add_user.js"></script>

  <script src="../../js/add_customer.js"></script>

  <script src="../../js/add_admin.js"></script>

  <script src="../../js/add_cashier.js"></script>

</head>

<div class="row">

  <h1 class="page-header">Create User</h1>

</div>

<div ng-app="add_user">

  <div ng-controller="addUser">

    <div class="row">

      <form novalidate role="form" name="myform" id="centerBlock">

        <div class="form-group">

          <label>User Name</label>

          <input class="inputField" type="text" class="form-control" ng-model="userName" name="userName" required/>

          <span ng-show="(myform.userName.$touched || myform.$submitted) && myform.userName.$invalid" id="inputControl" ng-cloak>

            User Name is Required

            <br>

          </span>

          <br><br>

          <label>First Name</label>

          <input class="inputField" type="text" class="form-control" ng-model="firstName" name="firstName" required/>

          <span ng-show="(myform.firstName.$touched || myform.$submitted) && myform.firstName.$invalid" id="inputControl" ng-cloak>

            First Name is Required

            <br>

          </span>

          <br><br>

          <label>Last Name</label>

          <input class="inputField" type="text" class="form-control" ng-model="lastName" name="lastName" required/>

          <span ng-show="(myform.lastName.$touched || myform.$submitted) && myform.lastName.$invalid" id="inputControl" ng-cloak>

            Last Name is Required

            <br>

          </span>

          <br><br>

          <label>Email</label>

          <input class="inputField" type="email" class="form-control" ng-model="email" name="email" required />

          <span ng-show="(myform.email.$touched || myform.$submitted) && myform.email.$invalid" id="inputControl" ng-cloak>

            Email is Required

            <br>

          </span>

          <br><br>

          <label>Phone Number</label>

          <input class="inputField" type="text" class="form-control" check-phone-number ng-model="phoneNumber" name="phoneNumber" required />

          <span ng-show="(myform.phoneNumber.$touched || myform.$submitted) && myform.phoneNumber.$error.checkPhoneNumber" id="inputControl" ng-cloak>

            Phone Number is invalid.it must be a number of at most 11 digits

            <br>

          </span>

          <span ng-show="(myform.phoneNumber.$touched || myform.$submitted) && myform.phoneNumber.$error.numberEmpty" id="inputControl" ng-cloak>

            Phone Number is Required

            <br>

          </span>

          <br><br>

          <div><label>Image</label></div>

          <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name="imageFileName" data-max-file-size="3">

          </div>

          <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">

          <img ng-src="{{ uploadme.src }}" style="width:300px;height:300px">

          <span>

            <button class="btn btn-primary" onclick="mylabel.click()" style="position:absolute;margin-top:150px">Choose image</button>

            <label id="mylabel" for="file"></label>

          </span>

          <br><br>

          <label>Password</label>

          <input class="inputField" type="password" class="form-control" ng-model="password" name="password" required />

          <span ng-show="(myform.password.$touched || myform.$submitted) && myform.password.$invalid" id="inputControl" ng-cloak>

            Password is Required

            <br>

          </span>

          <br><br>

          <label>Confirm Password</label>

          <input class="inputField" type="password" class="form-control" ng-model="confirmPassword" name="confirmPassword" required />

          <span ng-show="(myform.confirmPassword.$touched || myform.$submitted) && myform.confirmPassword.$invalid" id="inputControl" ng-cloak>

            Confirm Password is Required

            <br>

          </span>

          <br><br>
         
          <div><label>Choose Role</label></div>

          <a style="margin:auto" href="../../Areas/Admin/User/Views/add_user.php/1">Admin&nbsp;</a>

          <a style="margin:auto" href="../../Areas/Admin/User/Views/add_user.php/2">Cashier&nbsp;</a>

          <a style="margin:auto" href="../../Areas/Admin/User/Views/add_user.php/3">Customer&nbsp;</a>

          <div ng-view></div>

        </div>

      </form>

    </div>

  </div>

</div>