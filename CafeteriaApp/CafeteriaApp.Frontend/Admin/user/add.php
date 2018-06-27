<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([1]);
?>

<head>

  <title>Adding User</title>

  <meta name="viewport" content="width=device-width" />

  <link href="/css/input_file.css" rel="stylesheet">

</head>

<div class="row">

  <h1 class="page-header">Create User</h1>

</div>

<div ng-app="add_user">

  <div ng-controller="addUser">

    <div class="row">

      <form novalidate role="form" method="post" name="myform" id="centerBlock" ng-cloak action="/myapi/User" enctype="multipart/form-data">

        <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token" id="csrf_token">

        <div class="form-group">

          <label>First Name</label>

          <div><input class="inputField" type="text" class="form-control" ng-model="firstName" name="firstName" required /></div>

          <div class="errorMes" ng-show="(myform.firstName.$touched || myform.$submitted) && myform.firstName.$invalid">

            First Name is Required

            <br>

          </div>

          <br><br>

          <label>Last Name</label>

          <div><input class="inputField" type="text" class="form-control" ng-model="lastName" name="lastName" required /></div>

          <div class="errorMes" ng-show="(myform.lastName.$touched || myform.$submitted) && myform.lastName.$invalid">

            Last Name is Required

            <br>

          </div>

          <br><br>

          <label>Email</label>

          <div><input check class="inputField" type="email" class="form-control" ng-model="email" name="email" required /></div>

          <div class="errorMes" ng-show="(myform.email.$touched || myform.$submitted) && myform.email.$error.emailEmpty">

            Email is Required

          </div>

          <div class="errorMes" ng-show="(myform.email.$touched || myform.$submitted) && !myform.email.$error.emailEmpty && !myform.email.$error.emailExisted && myform.email.$invalid">

            Email is invalid

          </div>

          <div class="errorMes" ng-show="(myform.email.$touched || myform.$submitted) && myform.email.$error.emailExisted">

            Email already existed

          </div>

          <br><br>

          <label>Phone Number</label>

          <div><input check class="inputField" type="text" class="form-control" ng-model="phone" name="phone" required /></div>

          <div class="errorMes" ng-show="(myform.phone.$touched || myform.$submitted) && myform.phone.$error.checkPhoneNumber && !myform.phone.$error.phoneEmpty">

            Phone Number is Invalid. It must has 11 digits starting with 01

          </div>

          <div class="errorMes" ng-show="(myform.phone.$touched || myform.$submitted) && myform.phone.$error.phoneEmpty">

            Phone Number is Required

          </div>

          <br><br>

          <div><label>Image</label></div>

          <input type="file" name="image" id="file" class="inputfile" onchange="readURL(this);">

          <input type="hidden" name="x1" value="" />
          <input type="hidden" name="y1" value="" />
          <input type="hidden" name="w" value="" />
          <input type="hidden" name="h" value="" />

          <img id="image" class="img-block" style="width: 300px;height: 300px">

          <span>

            <button class="btn btn-primary" onclick="event.preventDefault();mylabel.click()" style="position: absolute;margin-top: 150px">Choose image</button>

            <label id="mylabel" for="file"></label>

          </span>

          <br><br>

          <label>Password</label>

          <div><input check class="inputField" type="password" class="form-control" ng-model="password" name="password" required /></div>

          <div class="errorMes" ng-show="(myform.password.$touched || myform.$submitted) && myform.password.$error.passEmpty">

            Password is Required

          </div>

          <div class="errorMes" ng-show="(myform.password.$touched || myform.$submitted) && myform.password.$error.checkPassword && !myform.password.$error.passEmpty">

            Password is Invalid. It must contain at least one lowercase letter, one uppercase letter and one digit

          </div>

          <br><br>

          <label>Confirm Password</label>

          <div><input class="inputField" check type="password" class="form-control" ng-model="confirmPassword" name="confirmPassword" required /></div>

          <div class="errorMes" ng-show="(myform.confirmPassword.$touched || myform.$submitted) && myform.confirmPassword.$error.confirmPassEmpty">

            Confirm Password is Required

          </div>

          <div class="errorMes" ng-show="(myform.confirmPassword.$touched || myform.$submitted) && !myform.confirmPassword.$error.checkConfirmPassword && !myform.confirmPassword.$error.confirmPassEmpty && password != confirmPassword">

            Confirm Password is not as the password

          </div>

          <div class="errorMes" ng-show="(myform.confirmPassword.$touched || myform.$submitted) && myform.confirmPassword.$error.checkConfirmPassword && !myform.confirmPassword.$error.confirmPassEmpty">
            
            Confirm Password is Invalid. It must contain at least one lowercase letter, one uppercase letter and one digit

          </div>

          <br><br>

          <div><label>Gender</label></div>

          <span style="margin: auto;margin-right: 20px">

            <label>Female</label><input id="femaleInput" name="genderId" type="radio" value="2">

          </span>

          <span style="margin: auto;margin-left: 20px">

            <label>Male</label><input id="maleInput" name="genderId" type="radio" value="1">

          </span>

          <br><br>

          <!-- <div><label>Role</label></div>

          <span style="margin: auto;margin-right: 20px">

            <label>Admin</label><input id="admin" value="1" name="role" type="radio">

          </span>

          <span style="margin: auto;margin-left: 20px">

            <label>Customer</label><input id="customer" value="2" name="role" type="radio">

          </span>

          <span style="margin: auto;margin-left: 20px">

            <label>Cashier</label><input id="cashier" value="3" name="role" type="radio">

          </span> -->

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

          <div class="errorMes" ng-show="(myform.DOB.$touched || myform.$submitted) && myform.DOB.$error.birthEmpty">

            Date of Birth is Required

          </div>

          <div class="errorMes" ng-show="(myform.DOB.$touched || myform.$submitted) && !myform.DOB.$error.birthEmpty && myform.DOB.$error.checkBirth">

            Date of Birth is Invalid

          </div>

          <input type="hidden" id="role" name="roleId" ng-model="role">

          <br><br>
         
          <div><label>Choose Role</label></div>

          <a onclick="$('#role').val(1);" style="margin: auto" href="/admin/users/add/1">Admin&nbsp;</a>

          <a onclick="$('#role').val(3);" style="margin: auto" href="/admin/users/add/2">Cashier&nbsp;</a>

          <a onclick="$('#role').val(2);" style="margin: auto" href="/admin/users/add/3">Customer&nbsp;</a>

          <div ng-view></div>

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

<script src="/js/angular-route.js"></script>
<script src="/js/add_user.js"></script>
<!-- <script src="/js/add_customer.js"></script>
<script src="/js/add_admin.js"></script>
<script src="/js/add_cashier.js"></script> -->
<script type="text/javascript" src="/js/register_form_validation.js"></script>