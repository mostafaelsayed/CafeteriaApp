<title>Categories</title>
<?php
include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
 ?>
 <script src="/CafeteriaApp.Frontend/Scripts/customer/category.js"></script>

 <!-- <div id="page-wrapper" style="margin-top:0px"> -->
<div>
    <div>
        <h1 class="page-header" style="text-align:center;margin-top:70px">Categories</h1>
    </div>
</div>

<div ng-app="myapp">

<div ng-controller="getByCafeteriaId">
<div ng-repeat="c in categories" class="container">
  <div  class="jumbotron">
  <div ng-bind="c.Name"></div>
</div>
  <!-- <img ng-src="/CafeteriaApp.Frontend/Scripts/CustomerTheme/images/bbig1.jpg" ng-href="/CafeteriaApp.Frontend/Areas/Customer/Views/show?id="+c.i /> -->
</div>
</div>
</div>
