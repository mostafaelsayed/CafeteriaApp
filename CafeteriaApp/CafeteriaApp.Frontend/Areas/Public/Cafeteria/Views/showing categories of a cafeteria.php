<title>Categories</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
?>

<script src="/CafeteriaApp.Frontend/Scripts/customer/showing categories of a cafeteria.js"></script>

<h1 class="page-header" style="text-align:center;margin-top:70px">Categories</h1>

<div ng-app="myapp" ng-controller="getCategories">
  <div ng-repeat="c in categories" style="width:15%;margin:auto">
    <a ng-href="/CafeteriaApp.Frontend/Areas/Customer/Category/Views/showing menuitems of a category and customer order.php?id={{c.Id}}" target="_self"><h2 style="text-align:center" ng-bind="c.Name"></h2></a>
    <br />
  </div>
</div>
