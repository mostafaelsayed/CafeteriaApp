<title>Adding Category</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/Scripts/admin/adding category.js"></script>

<link href="/CafeteriaApp.Frontend/Scripts/input_file.css" rel="stylesheet">

<div id="page-wrapper" style="margin-top:-600px">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Create Category</h1>
    </div>
  </div>

  <div class="col-lg-12" ng-app="myapp" ng-controller="addCategory">
    <div class="panel panel-default">
      <div class="panel-heading">Adding New Category</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-6">
            <form role="form" name="myform">
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" ng-model="name" autofocus="autofocus" name="name" required/>
                <span ng-show="myform.name.$invalid" id="inputControl">Category Name is Required</span>
                <div><label>Image</label></div>
                <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">
                </div>
                <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">
                <img ng-src="{{ uploadme.src }}" width="300" height="300">
                <br><br>
                <div><button class="btn btn-primary" onclick="mylabel.click()" id="mybutton">Choose image</button><label id="mylabel" for="file"></label></div>
              </div>
              <div class="form-group">
                <input type = "submit" value = "save" class="btn btn-primary" style="float:right" ng-click="addCategory()">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
   </div>

 </div>
