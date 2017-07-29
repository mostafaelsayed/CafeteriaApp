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
    <!-- <div class="container">
      <div ng-repeat="c in categories">
        <div ng-if="categories.indexOf(c) == 0 || categories.indexOf(c) % 3 == 0">
          <div class="row">
            <div ng-if="categories.length - categories.indexOf(c) >= 3">
              <div ng-repeat="a in categories.slice(categories.indexOf(c)+1,categories.indexOf(c)+3)">
                <div class="col-lg-4 well">
                  <div ng-bind="a.Name"></div>
                </div>
              </div>
            </div>
            <div ng-if="categories.length - categories.indexOf(c) < 3">
              <div ng-repeat="b in categories.slice(categories.indexOf(c)+1,categories.length)">
                <div class="col-lg-4 well">
                  <div ng-bind="b.Name"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <! <img ng-src="/CafeteriaApp.Frontend/Scripts/CustomerTheme/images/bbig1.jpg" ng-href="/CafeteriaApp.Frontend/Areas/Customer/Views/show?id="+c.i /> -->
    </div>
  </div>
</div>
