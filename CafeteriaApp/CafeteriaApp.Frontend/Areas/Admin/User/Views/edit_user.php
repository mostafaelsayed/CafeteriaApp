<title>Edit User</title>

<?php
  require_once("CafeteriaApp.Backend/functions.php"); 
  validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/javascript/edit_user.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/edit_customer.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/edit_cashier.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/edit_admin.js"></script>

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
               <!-- <label>Image</label>
               <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="image" name="image" required/>
               <span ng-show="myform.image.$invalid" id="inputControl">Image is Required<br></span><br> -->
               <!-- <div><label>Choose Role</label></div>
               <a style="margin: auto" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/1">Admin&nbsp;</a>
               <a style="margin: auto" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/2">Cashier&nbsp;</a>
               <a style="margin: auto" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/3">Customer&nbsp;</a> -->

                  <div ng-view></div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
