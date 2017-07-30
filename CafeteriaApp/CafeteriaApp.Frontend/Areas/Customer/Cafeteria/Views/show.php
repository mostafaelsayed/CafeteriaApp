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
    <div ng-repeat="c in categories">
      <div class="well well-small" style="width:15%;margin:auto">
        <a ng-href="/CafeteriaApp.Frontend/Areas/Customer/Category/Views/show.php?id={{c.Id}}" target="_self"><h2 style="text-align:center" ng-bind="c.Name"></h2></a>
      </div>
      <br />
    </div>
  </div>
</div>
