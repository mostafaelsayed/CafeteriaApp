<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([1]);
?>

<head>

  <title>Edit User</title>

  <link href="/css/input_file.css" rel="stylesheet">

</head>

<div class="row">

  <h1 class="page-header">Edit User</h1>

</div>

<div ng-app="edit_user">

  <div ng-controller="editUser">

    <div class="row">

      <form novalidate role="form" name="myform" class="css-form" id="centerBlock" ng-cloak>

        <div class="form-group" >

          <label>First Name</label>

          <div><input class="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userData.firstName" name="firstName" required /></div>

          <span ng-show="myform.firstName.$touched && myform.firstName.$invalid" id="inputControl" ng-cloak>

            First Name is Required

            <br>

          </span>

          <br><br>

          <label>Last Name</label>

          <div><input class="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="userData.lastName" name="lastName" required /></div>

          <span ng-show="myform.lastName.$touched && myform.lastName.$invalid" id="inputControl" ng-cloak>

            Last Name is Required

            <br>

          </span>

          <br><br>

          <label>Email</label>

          <div><input class="inputField" type="email" class="form-control" autofocus="autofocus" ng-model="em" name="email" required /></div>

          <!-- <div class="errorMes" ng-show="(myform.email.$touched || myform.$submitted) && myform.email.$error.emailEmpty && em ==''">

            Email is Required

          </div>

          <div class="errorMes" ng-show="(myform.email.$touched || myform.$submitted) && em !='' && myform.email.$invalid">

            Email is invalid

          </div> -->

          <!-- <div ng-bind="em"></div> -->

          <!-- <div class="errorMes" ng-show="(myform.email.$touched || myform.$submitted) && myform.email.$error.emailExisted">

            Email already existed

          </div> -->

          <br><br>

          <label>Phone Number</label>

          <div><input check class="inputField" type="text" class="form-control" autofocus="autofocus" check-phone-number ng-model="userData.phoneNumber" name="phone" required /></div>

          <div class="errorMes" ng-show="(myform.phone.$touched || myform.$submitted) && myform.phone.$error.checkPhoneNumber && !myform.phone.$error.phoneEmpty">

            Phone Number is Invalid. It must has 11 digits starting with 01

          </div>

          <div class="errorMes" ng-show="(myform.phone.$touched || myform.$submitted) && myform.phone.$error.phoneEmpty">

            Phone Number is Required

          </div>

          <br><br>

          <div><label>Image</label></div>

          <input type="file" name="image" id="file" class="inputfile" onchange="readURL(this);">

          <input type="hidden" id="x1" value="" />
          <input type="hidden" id="y1" value="" />
          <input type="hidden" id="w" value="" />
          <input type="hidden" id="h" value="" />

          <div ng-if="userData.imageUrl != ''">

            <img id="image" ng-src="{{ userData.imageUrl }}" style="width: 300px;height: 300px" />

            <span>

              <button class="btn btn-primary" onclick="event.preventDefault();mylabel.click()" style="position: absolute;margin-top: 150px" id="mybutton">Choose image</button>

              <label id="mylabel" for="file"></label>

            </span>

          </div>

          <!-- <div ng-if="userData.imageUrl == ''">

            <img ng-src="{{ userData.imageUrl }}" style="text-align: center;width: 300px;height: 300px">&nbsp;

            <span>

              <button class="btn btn-primary" onclick="mylabel.click()" style="position: absolute;margin-top: 150px" id="mybutton">Choose image</button>

              <label id="mylabel" for="file"></label>

            </span>

            <br>

          </div> -->

          <br>

          <div><label>Gender</label></div>

          <span style="margin: auto;margin-right: 20px">

            <label>Female</label><input id="femaleInput" name="genderId" type="radio" ng-model="selectedGender" value="2">

          </span>

          <span style="margin: auto;margin-left: 20px">

            <label>Male</label><input id="maleInput" name="genderId" ng-model="selectedGender" type="radio" value="1">

          </span>

          <div><br><label>Date of birth</label></div><br>

          <span style="margin: auto;margin-left: 40px">

            <label>Year</label>

            <select ng-options="year for year in years" ng-model="selectedYear.year"></select>

          </span>

          <span style="margin: auto">

            <label>Month</label>

            <select ng-options="month for month in months" ng-model="selectedMonth.month"></select>

          </span>

          <span style="margin: auto;margin-right: 40px">

            <label>Day</label>

            <select ng-options="day for day in days" ng-model="selectedDay.day"></select>

          </span>

          <input check type="hidden" id="dob" name="DOB" ng-model="dob">
          <input type="hidden" id="role" name="roleId" ng-model="role">

          <br><br>

          <div>

            <label>Change Role</label>

          </div>

          <span style="margin: auto">

            <select ng-options="role.name for role in roles" ng-change="angular.element('#role').val(selectedRole.id)" ng-model="selectedRole"></select>

          </span>

          <div ng-show="selectedRole.name == 'Customer'">

            <br><br>

            <div><label>Credit</label></div>

            <span style="margin: auto">

              <input type="text" ng-model="credit">

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

<style type="text/css">
  .errorMes {
    color: red;
  }
</style>

<script type="text/javascript">
  function readURL(input) {
    var file = input.files[0];

    if (input.files && file) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#image').attr('src', e.target.result);
      };

      reader.readAsDataURL(file);
    }
  }
</script>

<script src="/js/image_module.js"></script>
<script src="/js/phone_number_module.js"></script>
<script src="/js/edit_user.js"></script>
<script type="text/javascript" src="/js/register_form_validation.js"></script>