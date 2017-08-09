<title>Adding MenuItem</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/Scripts/admin/adding menuitem.js"></script>
<link href="/CafeteriaApp.Frontend/Scripts/input_file.css" rel="stylesheet">


<div id="page-wrapper" style="margin-top:-600px">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Create MenuItem</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp" ng-controller="addMenuItem">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">Adding New MenuItem</div>

        <div class="panel-body">
          <div class="row">
            <div class="col-lg-6">
              <form novalidate role="form" name="myform" class="css-form">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" required>
                  <span ng-show="myform.name.$invalid" id="inputControl">MenuItem Name is Required</span>
                  <div><label>Price</label></div>
                  <input type="text" class="form-control" ng-model="price" number-check name="price">
                  <span ng-show="myform.price.$error.numberCheck" id="inputControl">Price is invalid.it must be a number of at most 9 digits and optinally followed by at most 2 digit</span>
                  <span ng-show="myform.price.$error.numberEmpty" id="inputControl">Price is Required</span>
                  <div><label>Description</label></div>
                  <input type="text" class="form-control" ng-model="description" name="description" required>
                  <span ng-show="myform.description.$invalid" id="inputControl">Description is Required</span>
                  <div><label>Image</label></div>
                  <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">
                  </div>
                  <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">
                  <img ng-src="{{ uploadme.src }}" width="300" height="300">
                  <br><br>
                  <div><button class="btn btn-primary" onclick="mylabel.click()" id="mybutton">Choose image</button><label id="mylabel" for="file"></label></div>
                </div>
                <div class="form-group" style="float: right">
                  <button ng-click="addMenuItem()" ng-disabled="myform.$invalid" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
     </div>
   </div>
 </div>
 <!-- <script>

     var app = new CategoryNewViewModel(@ViewBag.cafeteriaId);
     ko.applyBindings(app);
 </script> -->
