<title>Edit MenuItem</title>

<?php
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/Scripts/admin/editing menuitem.js"></script>

<div id="page-wrapper" style="margin-top:-600px">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Edit MenuItem</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp" ng-controller="editMenuItem">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">Edit MenuItem</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-6">
              <form role="form">
                <div class="form-group" >
                  <label>Name</label>
                  <input type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" id="name" required>
                  <label>Price</label>
                  <input type="text" class="form-control" ng-model="price" name="name" id="name" required>
                  <label>Description</label>
                  <input type="text" class="form-control" ng-model="description" name="name" id="name" required>
                </div>
                <div class="form-group" style="float: right">
                  <button ng-click="editMenuItem()" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>