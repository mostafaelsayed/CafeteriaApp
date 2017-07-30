<title>Adding Category</title>

<?php
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/Scripts/admin/adding category.js"></script>

<div id="page-wrapper" style="margin-top:-600px">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Create Category</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp" ng-controller="addCategory">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">Adding New Category</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-6">
              <form role="form">
                <div class="form-group" >
                  <label>Name</label>
                  <input type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" id="name"  required>
                </div>
                <div class="form-group" style="float: right">
                  <button ng-click="addCategory()" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
     </div>
   </div>
 </div>
