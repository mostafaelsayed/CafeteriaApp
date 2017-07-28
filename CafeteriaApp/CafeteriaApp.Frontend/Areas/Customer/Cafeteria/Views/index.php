<title>Cafeterias</title>
<?php
include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
 ?>
 <script src="/CafeteriaApp.Frontend/Scripts/customer/cafeteria.js"></script>

 <!-- <div id="page-wrapper" style="margin-top:0px"> -->
<div>
    <div>
        <h1 class="page-header" style="text-align:center;margin-top:70px">Our Cafeterias</h1>
    </div>
</div>

<div ng-app="myapp">

<div ng-controller="getcafeterias">

<div ng-repeat="c in cafeterias">
  <!-- <div> -->
  <a ng-href="/CafeteriaApp.Frontend/Areas/Customer/Cafeteria/Views/show.php?id={{c.Id}}"><img style="display:block;margin: auto" ng-src="/CafeteriaApp.Frontend/Scripts/CustomerTheme/images/bbig1.jpg" width="500" height="400" /></a>
<!-- </div> --><br /><br /><br /><br /><br />
</div>
</div>
</div>
