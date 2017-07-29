<title>Categories</title>
<?php
include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
 ?>
 <script src="/CafeteriaApp.Frontend/Scripts/customer/menuitem.js"></script>

 <!-- <div id="page-wrapper" style="margin-top:0px"> -->
<div>
    <div>
        <h1 class="page-header" style="text-align:center;margin-top:70px">Categories</h1>
    </div>
</div>

<div ng-app="myapp">
  <div ng-controller="getMenuItems">
    <div class="panel-group">
      <div ng-repeat="m in menuItems">
        <div class="well well-small panel panel-default" style="width:60%;margin:auto">
          <h1 class="panel-header" ng-bind="m.Name"></h1>
          <div class="panel-body">
            <div>Name:  <span ng-bind="m.Name"></span></div>
            <div>Price:  <span ng-bind="m.Price"></span></div>
            <div>Description:  <span ng-bind="m.Description"></span></div>
          </div>
        </div>
        <br />
      </div>
    </div>
  </div>
</div>
