<title>Edit User</title>

<?php
  require_once("CafeteriaApp.Backend/functions.php"); 
  validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/javascript/edit_user.js"></script>

<link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

<div class="row">
  <h1 class="page-header">Edit User</h1>
</div>

<div ng-app="myapp">
  <div ng-controller="editUser">
    <div class="row">
      <form novalidate role="form" name="myform" class="css-form" id="centerBlock">
        <div class="form-group" >
           <label>User Name</label>
           <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userData.userName" name="userName" required/>
           <span ng-show="myform.userName.$invalid" id="inputControl">User Name is Required<br></span><br>
           <label>First Name</label>
           <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userData.firstName" name="firstName" required/>
           <span ng-show="myform.firstName.$invalid" id="inputControl">First Name is Required<br></span><br>
           <label>Last Name</label>
           <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userData.lastName" name="lastName" required/>
           <span ng-show="myform.lastName.$invalid" id="inputControl">Last Name is Required<br></span><br>
           <label>Email</label>
           <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userData.email" name="email" required/>
           <span ng-show="myform.email.$invalid" id="inputControl">Email is Required<br></span><br>
           <label>Phone Number</label>
           <input id="inputField" type="text" class="form-control" autofocus="autofocus" check-phone-number ng-model="userData.phoneNumber" name="phoneNumber" required/>
           <span ng-show="myform.phoneNumber.$error.checkPhoneNumber" id="inputControl">Phone Number is invalid.it must be a number of at most 11 digits<br></span>
           <span ng-show="myform.phoneNumber.$error.numberEmpty" id="inputControl">Phone Number is Required<br></span><br>

           <br>
           <div><label>Change Role</label></div>
           <span style="margin: auto">
            <select ng-options="role.Name for role in roles" ng-model="selectedRole"></select>
           </span>

            <div ng-show="selectedRole.Name=='Customer'">
             <div><label>Gender</label></div>
             <span style="margin: auto;margin-right: 20px">
              <label>Female</label><input id="femaleInput" type="checkbox">
             </span>
             <span style="margin: auto;margin-left: 20px">
              <label>Male</label><input id="maleInput" type="checkbox">
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
            <br><br>
            <div><button ng-click="save()" class="btn btn-primary">Save</button></div>
            <!-- <label>Image</label>
            <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="image" name="image" required/>
            <span ng-show="myform.image.$invalid" id="inputControl">Image is Required<br></span><br> -->
        </div>
      </form>
    </div>
  </div>
</div>