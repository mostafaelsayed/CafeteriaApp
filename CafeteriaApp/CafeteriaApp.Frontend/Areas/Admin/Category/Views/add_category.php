<?php

  require_once("CafeteriaApp.Backend/functions.php");

  validatePageAccess($conn);

  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<head>

  <title>Adding Category</title>

  <link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

  <script src="/CafeteriaApp.Frontend/javascript/image_module.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/location_provider.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/add_category.js"></script>

</head>

<div class="row">
  
  <h1 class="page-header">Create Category</h1>

</div>

<div ng-app="add_category" ng-controller="addCategory">

  <div class="row">

    <form novalidate role="form" name="myform" id="centerBlock">

      <div class="form-group">

        <label>Name</label>

        <input id="inputField" type="text" class="form-control" ng-model="name" autofocus="autofocus" name="name" required />

        <span ng-show="myform.$submitted && myform.name.$invalid" id="inputControl" ng-cloak>

          Category Name is Required

          <br>

        </span>

        <br>

        <div><label>Image</label></div>

        <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">

        </div>

        <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">

        <img ng-src="{{ uploadme.src }}" width="300" height="300">

        <br><br>

        <div><button class="btn btn-primary" onclick="mylabel.click()" id="mybutton">Choose image</button><label id="mylabel" for="file"></label></div>

      </div>

      <div class="form-group">

        <input type = "submit" value = "save" class="btn btn-primary" ng-click="addCategory()">

      </div>

    </form>

  </div>

</div>