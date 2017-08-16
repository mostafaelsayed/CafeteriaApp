<title>Edit User</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/javascript/edit_user.js"></script>
<link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

<div>

  <div class="row">
    <div>
      <h1 class="page-header">Edit User</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp" ng-controller="editUser">
    <div>
      <div>
        <div>
          <div class="row">
            <div>
              <form novalidate role="form" name="myform" class="css-form" id="centerBlock">
                <div class="form-group" >
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
               <!-- <label>Image</label>
               <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="image" name="image" required/>
               <span ng-show="myform.image.$invalid" id="inputControl">Image is Required<br></span><br> -->
               <div><label>Choose Role</label></div>
               <select ng-options="role for role in roles" ng-model="selectedRole"></select>
               <div ng-show="selectedRole == 'Customer'">
                <br>
                <div><label>Gender</label></div>
                <span style="margin: auto;margin-right: 20px">
                  <label>Female</label><input id="femaleInput" type="checkbox" ng-click="femaleChecked()">
                </span>
                <span style="margin: auto;margin-left: 20px">
                  <label>Male</label><input id="maleInput" type="checkbox" ng-click="maleChecked()">
                </span>
                <div><br><label>Date of birth</label></div><br>
                <div style="float: left;margin-left: 500px">
                  <label>Year</label>
                  <select ng-options="year for year in years" ng-model="selectedYear"></select>
                </div>
                <span style="margin: auto">
                  <label>Month</label>
                  <select ng-options="month for month in months" ng-model="selectedMonth"></select>
                </span>
                <span style="float: right;margin-right: 500px">
                  <label>Day</label>
                  <select ng-options="day for day in days" ng-model="selectedDay"></select>
                </span>
                
               </div>
                </div>
                <div class="form-group">
                  <button ng-click="editUser()" class="btn btn-primary">Save</button>
                </div>             
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
