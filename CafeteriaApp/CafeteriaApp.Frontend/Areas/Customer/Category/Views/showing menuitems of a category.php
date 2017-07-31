<title>MenuItems</title>

<?php
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
?>

<script src="/CafeteriaApp.Frontend/Scripts/customer/showing menuitems of a category.js"></script>

<div>
    <div>
        <h1 class="page-header" style="text-align:center;margin-top:70px">MenuItems</h1>
    </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div ng-app="myapp" class="col-lg-8">
      <div ng-controller="getMenuItems">
        <div class="panel-group">
          <div ng-repeat="m in menuItems">
            <div class="well well-small panel panel-default" style="width:40%">
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
    <div class="col-lg-4">
      <div class="container">
        <div class="table table-bordered">
          <thead>
            <tr>
              <th>OrderItem</th>
              <th>Quantity</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </div>
      </div>
    </div>
  </div>
</div>
