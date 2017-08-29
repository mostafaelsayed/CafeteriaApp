<title>Adding MenuItem</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/javascript/add_menuitem.js"></script>
<link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">


<div>
  <div class="row">
    <div>
      <h1 class="page-header">Create MenuItem</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp" ng-controller="addMenuItem">
    <div>
      <div>
        <div>
          <div class="row">
            <div>
              <form novalidate role="form" name="myform" class="css-form" id="centerBlock">
                <div class="form-group">
                  <label>Name</label>
                  <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" required>
                  <span ng-show="myform.$submitted && myform.name.$invalid" id="inputControl">MenuItem Name is Required<br></span><br>
                  <div><label>Price</label></div>
                  <input id="inputField" type="text" class="form-control" ng-model="price" number-check name="price">
                  <span ng-show="myform.$submitted && myform.price.$error.numberCheck" id="inputControl">Price is invalid.it must be a number of at most 9 digits and optinally followed by at most 2 digit<br></span>
                  <span ng-show="myform.$submitted && myform.price.$error.numberEmpty" id="inputControl">Price is Required<br></span><br>
                  <div><label>Description</label></div>
                  <input id="inputField" type="text" class="form-control" ng-model="description" name="description" required>
                  <span ng-show="myform.$submitted && myform.description.$invalid" id="inputControl">Description is Required<br></span><br>
                  <div><label>Image</label></div>
                  <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">
                  </div>
                  <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">
                  <img ng-src="{{ uploadme.src }}" width="300" height="300">
                  <br><br>
                  <div><button class="btn btn-primary" onclick="mylabel.click()" id="mybutton">Choose image</button><label id="mylabel" for="file"></label></div>
                </div>
                <div class="form-group">
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
