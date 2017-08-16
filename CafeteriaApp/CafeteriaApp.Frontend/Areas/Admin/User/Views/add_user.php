<?php

  require_once("CafeteriaApp.Backend/functions.php"); 
  validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
  
?>

<script src="/CafeteriaApp.Frontend/javascript/add_user.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/add_customer.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/admin.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/add_cashier.js"></script>

<link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

<head>
  <meta name="viewport" content="width=device-width" />
  <title>Adding User</title>
</head>


<div>
  <div class="row">
    <div>
      <h1 class="page-header">Create User</h1>
    </div>
  </div>
  <div ng-app="myapp">
    <div ng-controller="addUser">
      <div>
        <div>
          <div class="row">
             <div>
  	           <form novalidate role="form" name="myform" id="centerBlock">
                <div class="form-group">
  		           <label>User Name</label>
  		           <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userName" name="userName" required/>
                 <span ng-show="myform.userName.$invalid" id="inputControl">User Name is Required<br></span><br>
                 <label>First Name</label>
                 <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="firstName" name="firstName" required/>
                 <span ng-show="myform.firstName.$invalid" id="inputControl">First Name is Required<br></span><br>
                 <label>Last Name</label>
                 <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="lastName" name="lastName" required/>
                 <span ng-show="myform.lastName.$invalid" id="inputControl">Last Name is Required<br></span><br>
                 <label>Email</label>
                 <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="email" name="email" required/>
                 <span ng-show="myform.email.$invalid" id="inputControl">Email is Required<br></span><br>
                 <label>Phone Number</label>
                 <input id="inputField" type="text" class="form-control" autofocus="autofocus" check-phone-number ng-model="phoneNumber" name="phoneNumber" required/>
                 <span ng-show="myform.phoneNumber.$error.checkPhoneNumber" id="inputControl">Phone Number is invalid.it must be a number of at most 11 digits<br></span>
                 <span ng-show="myform.phoneNumber.$error.numberEmpty" id="inputControl">Phone Number is Required<br></span><br>
                 <label>Password</label>
                 <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="password" name="password" required/>
                 <span ng-show="myform.password.$invalid" id="inputControl">Password is Required<br></span><br>
                 <label>Confirm Password</label>
                 <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="confirmPassword" name="confirmPassword" required/>
                 <span ng-show="myform.password.$invalid" id="inputControl">Confirm Password is Required<br></span><br>
                 <!-- <label>Image</label>
                 <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="image" name="image" required/>
                 <span ng-show="myform.image.$invalid" id="inputControl">Image is Required<br></span><br> -->
                 <div><label>Choose Role</label></div>
                 <a style="margin: auto" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/1">Admin&nbsp;</a>
                 <a style="margin: auto" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/2">Cashier&nbsp;</a>
                 <a style="margin: auto" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/3">Customer&nbsp;</a>

                 <div ng-view></div>
                 <!-- <div ng-show="selectedRole == 'Customer'">

                  <br>
                  <div><label>Gender</label></div>
                  <span style="margin: auto;margin-right: 20px">
                    <label>Female</label><input id="femaleInput" type="checkbox" ng-click="femaleChecked()">
                  </span>
                  <span style="margin: auto;margin-left: 20px">
                    <label>Male</label><input id="maleInput" type="checkbox" ng-click="maleChecked()">
                  </span>
                  <div><br><label>Date of birth</label></div><br>
                  <div style="float: left;margin-left: 600px">
                    <label>Year</label>
                    <select ng-options="year for year in years" ng-model="selectedYear"></select>
                  </div>
                  <span style="margin: auto">
                    <label>Month</label>
                    <select ng-options="month for month in months" ng-model="selectedMonth"></select>
                  </span>
                  <span style="float: right;margin-right: 600px">
                    <label>Day</label>
                    <select ng-options="day for day in days" ng-model="selectedDay"></select>
                  </span>
                  <div><label>Image</label></div>
                 <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name="imageFileName" data-max-file-size="3">
                 </div>
                 <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">
                 <img ng-src="{{ uploadme.src }}" width="300" height="300">
                 <br><br>
                 <div><button class="btn btn-primary" onclick="mylabel.click()">Choose image</button><label id="mylabel" for="file"></label></div> 

                 </div> -->
                </div>
                <!-- <div class="form-group">
  		           <input type = "submit" value = "save" class="btn btn-primary" ng-click="addUser()">
                </div> -->
  	           </form>
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>