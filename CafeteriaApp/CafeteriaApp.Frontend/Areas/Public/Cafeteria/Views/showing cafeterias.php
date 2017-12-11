<?php

  require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/functions.php');

  require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Customer/layout.php');

?>

<head>

  <title>Cafeterias</title>

  <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/alertify.bootstrap.css" rel="stylesheet">

  <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/alertify.core.css" rel="stylesheet">
  
  <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/alertify.default.css" rel="stylesheet">

  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/alertify.js"></script>

  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/show_cafeterias.js"></script>

</head>

<div class="container" style="position: static">

  <!-- <div ng-controller="toggle" style="text-align: center;margin-top: 20px"> -->

    <div class="popup" style="text-align: center;margin-top: 20px">

      <span class="popuptext" id="myPopup">A Simple Popup!</span>

    </div>

  <!-- </div> -->

  <h1 class="page-header" id="header">Our Cafeterias</h1>

  <div ng-controller="cafeterias">

    <div id="myCarousel" class="carousel slide" data-ride="carousel">

      <ol class="carousel-indicators">

        <li data-target="#myCarousel" data-slide-to=0 class="active"></li>

        <li ng-repeat="c in cafeterias.slice(1, cafeterias.length)" data-target="#myCarousel" data-slide-to={{cafeterias.indexOf(c)}}></li>

      </ol>

      <div class="carousel-inner">

        <div class="item active">

          <a ng-href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing categories of a cafeteria.php?id={{cafeterias[0].Id}}">

          <img style="display:block;margin:auto;width:300px ;height:300px" ng-src={{cafeterias[0].Image}} />

        </a>

        <h3 ng-bind="cafeterias[0].Name" class="carousel-caption"></h3>

        </div>

        <div ng-repeat="c in cafeterias.slice(1, cafeterias.length)" class="item">

          <a ng-href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing categories of a cafeteria.php?id={{c.Id}}">

            <img style="display:block;margin:auto;width:300px ;height:300px" ng-src={{c.Image}} />

          </a>

          <h3 ng-bind="c.Name" class="carousel-caption"></h3>

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

<?php require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/footer.php'); ?>