<?php

  require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/functions.php');

  validatePageAccess($conn);

  require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<head>

  <title>Adding Fee</title>

  <meta name="viewport" content="width=device-width" />

  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/price_module.js"></script>

  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/add_fee.js"></script>

</head>

<div class="row">

  <h1 class="page-header">Create Fee</h1>

</div>

<div ng-app="add_fee" ng-controller="addFee">

  <div class="row">

    <form novalidate role="form" name="myform" id="centerBlock">

      <div class="form-group">

        <label>Fee Name</label>

        <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" required />

        <span ng-show="myform.name.$touched && myform.name.$invalid" id="inputControl" ng-cloak>

          Fee Name is Required

          <br>

        </span>

        <br>

        <div><label>Price</label></div>

        <input id="inputField" type="text" class="form-control" number-check autofocus="autofocus" ng-model="price" name="price" required />

        <span ng-show="myform.price.$touched && myform.price.$error.numberEmpty" id="inputControl" ng-cloak>

          Price is Required

        </span>

        <span ng-show="myform.price.$touched && myform.price.$error.numberCheck" id="inputControl" ng-cloak>

          Price is invalid.it must be a number of at most 9 digits and optinally followed by at most 2 digit

          <br>

        </span>

      </div>

      <div class="form-group">

        <input type="submit" value="save" class="btn btn-primary" ng-click="addFee()">

      </div>

    </form>

  </div>

</div>