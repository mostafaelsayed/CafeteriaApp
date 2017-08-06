
<?php
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/Scripts/admin/adding cafeteria.js"></script>

<link href="/CafeteriaApp.Frontend/Scripts/input_file.css" rel="stylesheet">

<head>
  <meta name="viewport" content="width=device-width" />
  <title>Adding Cafeteria</title>
</head>


<div id="page-wrapper" style="margin-top:-600px">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Create Cafeteria</h1>
    </div>
  </div>
  <div class="col-lg-12" ng-app="myapp" ng-controller="addCafeteria">
    <div class="panel panel-default">
      <div class="panel-heading">Adding New Cafeteria</div>
      <div class="panel-body">
        <div class="row">
           <div class="col-lg-6">
	           <form role="form" name="myform">
              <div class="form-group">
		           <label>Name</label>
		           <input type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" required/>
               <span ng-show="myform.name.$invalid" id="inputControl">Cafeteria Name is Required</span>
		           <div><label>Image</label></div>
               <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name="imageFileName" data-max-file-size="3">
               </div>
               <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">
               <img ng-src="{{ uploadme.src }}" width="300" height="300">
               <br><br>
               <div><button class="btn btn-primary" onclick="mylabel.click()">Choose image</button><label id="mylabel" for="file"></label></div> 
              </div>
              <div class="form-group">
		           <input type = "submit" value = "save" class="btn btn-primary" style="float:right" ng-click="addCafeteria()">
              </div>
	           </form>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>