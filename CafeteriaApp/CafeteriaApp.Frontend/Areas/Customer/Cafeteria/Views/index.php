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
    <div  id="myCarousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to=0 class="active"></li>
          <li ng-repeat="c in cafeterias | limitTo:1:cafeterias.length-1" data-target="#myCarousel" data-slide-to={{cafeterias.indexOf(c)}}></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <a ng-href="/CafeteriaApp.Frontend/Areas/Customer/Cafeteria/Views/show.php?id={{cafeterias[0].Id}}">
            <img style="display:block;margin:auto" ng-src="/CafeteriaApp.Frontend/Scripts/CustomerTheme/images/bbig1.jpg" width="500" height="400" />
          </a>
          <div class="carousel-caption">
            <h3 ng-bind="cafeterias[0].Name"></h3>
          </div>
        </div>
        <div ng-repeat="c in cafeterias | limitTo:1:cafeterias.length-1" class="item">
            <a ng-href="/CafeteriaApp.Frontend/Areas/Customer/Cafeteria/Views/show.php?id={{c.Id}}">
              <img style="display:block;margin:auto" ng-src="/CafeteriaApp.Frontend/Scripts/CustomerTheme/images/bbig3.jpg" width="500" height="400" />
            </a>
            <div class="carousel-caption">
              <h3 ng-bind="c.Name"></h3>
            </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</div>
