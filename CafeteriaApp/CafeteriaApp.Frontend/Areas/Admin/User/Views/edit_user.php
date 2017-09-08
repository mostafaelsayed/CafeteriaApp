<?php

  require('CafeteriaApp.Backend/functions.php');

  validatePageAccess($conn);

  require('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<head>

  <title>Edit User</title>

  <link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

  <script src="/CafeteriaApp.Frontend/javascript/image_module.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/location_provider.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/phone_number_module.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/edit_user.js"></script>

</head>

<div class="row">

  <h1 class="page-header">Edit User</h1>

</div>

<div ng-app="edit_user">

  <div ng-controller="editUser">

    <div class="row">

      <form novalidate role="form" name="myform" class="css-form" id="centerBlock">

        <div class="form-group" >

          <label>User Name</label>

          <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userData.userName" name="userName" required />

          <span ng-show="myform.userName.$touched && myform.userName.$invalid" id="inputControl" ng-cloak>

            User Name is Required

            <br>

          </span>

          <br>

          <label>First Name</label>

          <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userData.firstName" name="firstName" required />

          <span ng-show="myform.firstName.$touched && myform.firstName.$invalid" id="inputControl" ng-cloak>

            First Name is Required

            <br>

          </span>

          <br>

          <label>Last Name</label>

          <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userData.lastName" name="lastName" required />

          <span ng-show="myform.lastName.$touched && myform.lastName.$invalid" id="inputControl" ng-cloak>

            Last Name is Required

            <br>

          </span>

          <br>

          <label>Email</label>

          <input id="inputField" type="email" class="form-control" autofocus="autofocus" ng-model="userData.email" name="email" required />

          <span ng-show="myform.email.$touched && myform.email.$invalid" id="inputControl" ng-cloak>

            Email is Required

            <br>

          </span>

          <br>

          <label>Phone Number</label>

          <input id="inputField" type="text" class="form-control" autofocus="autofocus" check-phone-number ng-model="userData.phoneNumber" name="phoneNumber" required />

          <span ng-show="myform.phoneNumber.$touched && myform.phoneNumber.$error.checkPhoneNumber" id="inputControl" ng-cloak>

            Phone Number is invalid.it must be a number of at most 11 digits

            <br>

          </span>

          <span ng-show="myform.phoneNumber.$touched && myform.phoneNumber.$error.numberEmpty" id="inputControl" ng-cloak>

            Phone Number is Required

            <br>

          </span>

          <br><br>

          <div><label>Image</label></div>

          <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">

          </div>

          <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">

          <div ng-if="uploadme.src != ''">

            <img ng-src="{{ uploadme.src }}" style="width:300px;height:300px" />

          </div>

          <div ng-if="uploadme.src == ''">

            <img ng-src="{{ userData.imageUrl }}" style="text-align:center;width:300px;height:300px">&nbsp;

            <span>

              <button class="btn btn-primary" onclick="mylabel.click()" style="position:absolute;margin-top:150px" id="mybutton">Choose image</button>

              <label id="mylabel" for="file"></label>

            </span>

            <br>

          </div>

          <br>

          <div>

            <label>Change Role</label>

          </div>

          <span style="margin:auto">

            <select ng-options="role.Name for role in roles" ng-model="selectedRole"></select>

          </span>

          <div ng-show="selectedRole.Name=='Customer'">

            <div><label>Credit</label></div>

            <span style="margin:auto">

              <input type="text" ng-model="credit">

            </span>

            <div><label>Gender</label></div>

            <span style="margin:auto;margin-right:20px">

              <label>Female</label><input id="femaleInput" type="checkbox">

            </span>

            <span style="margin:auto;margin-left:20px">

              <label>Male</label><input id="maleInput" type="checkbox">

            </span>

            <div><br><label>Date of birth</label></div><br>

            <div style="float:left;margin-left:500px">

              <label>Year</label>

              <select ng-options="year for year in years" ng-model="selectedYear"></select>

            </div>

            <span style="margin:auto">

              <label>Month</label>

              <select ng-options="month for month in months" ng-model="selectedMonth"></select>

            </span>

            <span style="float:right;margin-right:500px">

              <label>Day</label>

              <select ng-options="day for day in days" ng-model="selectedDay"></select>

            </span>

          </div>

          <br><br>

          <div>

            <button ng-click="save()" class="btn btn-primary">Save</button>

          </div>

        </div>

      </form>

    </div>

  </div>

</div>