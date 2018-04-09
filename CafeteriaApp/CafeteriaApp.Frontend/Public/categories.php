<?php
  
  require(__DIR__ . '/../layout.php');
  //validatePageAccess([1,2,3], false);
?>

<head>

  <title>Food Categories</title>

  <link href="../css/alertify.bootstrap.css" rel="stylesheet">
  <link href="../css/alertify.core.css" rel="stylesheet">
  <link href="../css/alertify.default.css" rel="stylesheet">

  <style type="text/css">
.w3-animate-zoom {
    animation: animatezoom 0.6s
}
@keyframes animatezoom {
    from {
        transform: scale(0)
    }
    to {
        transform: scale(1)
    }
}
  </style>
</head>

<div class="container" style="position: static">

  <h1 class="page-header" id="header">Food Categories</h1>

  <div class="w3-animate-zoom" ng-controller="cafeterias">

    <div id="myCarousel" class="carousel slide" data-ride="carousel">

      <ol class="carousel-indicators">

        <li data-target="#myCarousel" data-slide-to=0 class="active"></li>

        <li ng-repeat="c in cafeterias.slice(1, cafeterias.length)" data-target="#myCarousel" data-slide-to={{cafeterias.indexOf(c)}}></li>

      </ol>

      <div class="carousel-inner">

        <div class="item active">

          <a ng-href="menus.php?menu_id={{cafeterias[0].Id}}">

          <img class="img-rounded" style="display: block;margin: auto;width: 300px;height: 300px" ng-src={{cafeterias[0].Image}} />

          <h3 style="color:orange;transform:rotate(-15deg);" ng-bind="cafeterias[0].Name" class="carousel-caption" title="see menus"></h3>
        </a>

        </div>

        <div ng-repeat="c in cafeterias.slice(1, cafeterias.length)" class="item">

          <a ng-href="menus.php?id={{c.Id}}">

            <img style="display: block;margin: auto;width: 300px;height: 300px" ng-src={{c.Image}} />

          </a>

          <h3 g-bind="c.Name" class="carousel-caption"></h3>

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

<?php require(__DIR__.'/footer.php'); ?>

<script src="../js/alertify.js"></script>
<script src="../js/show_cafeterias.js"></script>