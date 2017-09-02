<?php

  require_once('CafeteriaApp.Backend/functions.php');

  validatePageAccess($conn);

  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
  
?>

<head>

  <title>Adding User</title>

  <meta name="viewport" content="width=device-width" />

  <link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

  <script src="/CafeteriaApp.Frontend/javascript/angular-route.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/image_module.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/location_provider.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/phone_number_module.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/price_module.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/add_user.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/add_customer.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/add_admin.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/add_cashier.js"></script>

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

          <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userName" name="userName" required/>

          <span ng-show="myform.userName.$touched && myform.userName.$invalid" id="inputControl" ng-cloak>

            User Name is Required

            <br>

          </span>

          <br>

          <label>First Name</label>

          <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="firstName" name="firstName" required/>

          <span ng-show="myform.firstName.$touched && myform.firstName.$invalid" id="inputControl" ng-cloak>

            First Name is Required

            <br>

          </span>

          <br>

          <label>Last Name</label>

          <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="lastName" name="lastName" required/>

          <span ng-show="myform.lastName.$touched && myform.lastName.$invalid" id="inputControl" ng-cloak>

            Last Name is Required

            <br>

          </span>

          <br>

          <label>Email</label>

          <input id="inputField" type="email" class="form-control" autofocus="autofocus" ng-model="email" name="email" required />

          <span ng-show="myform.email.$touched && myform.email.$invalid" id="inputControl" ng-cloak>

            Email is Required

            <br>

          </span>

          <br>

          <label>Phone Number</label>

          <input id="inputField" type="text" class="form-control" autofocus="autofocus" check-phone-number ng-model="phoneNumber" name="phoneNumber" required />

          <span ng-show="myform.phoneNumber.$touched && myform.phoneNumber.$error.checkPhoneNumber" id="inputControl" ng-cloak>

            Phone Number is invalid.it must be a number of at most 11 digits

            <br>

          </span>

          <span ng-show="myform.phoneNumber.$touched && myform.phoneNumber.$error.numberEmpty" id="inputControl" ng-cloak>

            Phone Number is Required

            <br>

          </span>

          <br>

          <label>Password</label>

          <input id="inputField" type="password" class="form-control" autofocus="autofocus" ng-model="password" name="password" required />

          <span ng-show="myform.password.$touched && myform.password.$invalid" id="inputControl" ng-cloak>

            Password is Required

            <br>

          </span>

          <br>

          <label>Confirm Password</label>

          <input id="inputField" type="password" class="form-control" autofocus="autofocus" ng-model="confirmPassword" name="confirmPassword" required />

          <span ng-show="myform.confirmPassword.$touched && myform.password.$invalid" id="inputControl" ng-cloak>

            Confirm Password is Required

            <br>

          </span>

          <br>
         
          <div><label>Choose Role</label></div>

          <a style="margin:auto" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/1">Admin&nbsp;</a>

          <a style="margin:auto" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/2">Cashier&nbsp;</a>

          <a style="margin:auto" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/3">Customer&nbsp;</a>

          <div ng-view></div>

        </div>

      </form>

    </div>

  </div>

</div>