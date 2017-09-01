<?php

  require_once("CafeteriaApp.Backend/functions.php");

  validatePageAccess($conn);

  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<head>

  <title>Adding MenuItem</title>

  <link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

  <script src="/CafeteriaApp.Frontend/javascript/location_provider.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/image_module.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/price_module.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/add_menuitem.js"></script>

</head>

<div class="row">

  <h1 class="page-header">Create MenuItem</h1>

</div>

<div class="row" ng-app="add_menuitem" ng-controller="addMenuItem">

  <div class="row">

    <form novalidate role="form" name="myform" class="css-form" id="centerBlock">

      <div class="form-group">

        <label>Name</label>

        <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" required />

        <span ng-show="myform.$submitted && myform.name.$invalid" id="inputControl" ng-cloak>

          MenuItem Name is Required

          <br>

        </span>

        <br>

        <div><label>Price</label></div>

        <input id="inputField" type="text" class="form-control" ng-model="price" number-check name="price">

        <span ng-show="myform.$submitted && myform.price.$error.numberCheck" id="inputControl" ng-cloak>

          Price is invalid.it must be a number of at most 9 digits and optinally followed by at most 2 digit

          <br>

        </span>

        <span ng-show="myform.$submitted && myform.price.$error.numberEmpty" id="inputControl" ng-cloak>

          Price is Required

          <br>

        </span>

        <br>

        <div><label>Description</label></div>

        <input id="inputField" type="text" class="form-control" ng-model="description" name="description" required />

        <span ng-show="myform.$submitted && myform.description.$invalid" id="inputControl" ng-cloak>

          Description is Required

          <br>

        </span>

        <br>

        <div><label>Image</label></div>

        <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">

        </div>

        <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">

        <img ng-src="{{ uploadme.src }}" style="width:300px;height:300px">

        <span>

          <button class="btn btn-primary" onclick="mylabel.click()" style="position:absolute;margin-top:150px">Choose image</button>

          <label id="mylabel" for="file"></label>

        </span>

      </div>

      <div class="form-group">

        <button ng-click="addMenuItem()" ng-disabled="myform.$invalid" class="btn btn-primary">Save</button>

      </div>

    </form>

  </div>

</div>