<?php

  require_once("CafeteriaApp.Backend/functions.php"); 
  validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<script src="/CafeteriaApp.Frontend/javascript/add_cafeteria.js"></script>

<link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

<head>
  <meta name="viewport" content="width=device-width" />
  <title>Adding Cafeteria</title>
</head>


<div>
  <div class="row">
    <div>
      <h1 class="page-header">Create Cafeteria</h1>
    </div>
  </div>
  <div ng-app="myapp" ng-controller="addCafeteria">
    <div>
      <div>
        <div class="row">
           <div>
	           <form novalidate role="form" name="myform" id="centerBlock">
              <div class="form-group">
		           <label>Name</label>
		           <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" required/>
               <span ng-show=" myform.$submitted &&myform.name.$invalid" id="inputControl">Cafeteria Name is Required<br></span><br>
		           <div><label>Image</label></div>
               <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name="imageFileName" data-max-file-size="3">
               </div>
               <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">
               <img ng-src="{{ uploadme.src }}" width="300" height="300">
               <br><br>
               <div><button class="btn btn-primary" onclick="mylabel.click()">Choose image</button><label id="mylabel" for="file"></label></div> 
              </div>
              <div class="form-group">
		           <input type = "submit" value = "save" class="btn btn-primary" ng-click="addCafeteria()">
              </div>
	           </form>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>