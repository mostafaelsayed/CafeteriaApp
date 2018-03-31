<?php

  require(__DIR__.'/../../CafeteriaApp.Backend/functions.php');
  validatePageAccess($conn);
  require(__DIR__.'/../layout.php');
   
?>

<head>

  <title>Favorite Items</title>

  <link href="../../css/favorite items.css" rel="stylesheet">

  <link href="../../css/popup.css" rel="stylesheet">

  <script src="../../javascript/favorite items.js"></script>

</head>

<div class="container" ng-controller="favorites" style="text-align: center;position: relative">

  <div>

    <h2 style="color: orange">My Favorites</h2>

    <div class="popup" style="float: right">

      <span class="popuptext" id="myPopup">A Simple Popup!</span>

    </div>

  </div>

  <table class="table" style="margin: auto" ng-show="favoriteItems.length > 0" ng-cloak>

    <thead>

      <tr>

        <th id="thead">Name</th>

        <th id="thead">Description</th>

        <th id="thead">Price</th>

        <th id="thead" style="text-align: center">Image</th>

      </tr>

    </thead>

    <tbody>

      <tr ng-repeat="fi in favoriteItems">

        <td ng-bind="fi.Name" id="thead"></td>

        <td ng-bind="fi.Description" id="thead"></td>

        <td ng-bind="fi.Price" id="thead"></td>

        <td><img src="{{fi.Image}}"></td>

        <td style="vertical-align: middle"> 
       
          <a class="btn btn-primary btn-circle" title="Remove Favorite Item" ng-click="deleteFavorItem(fi.MenuItemId,$index);" style="color: white"><i class="fa fa-minus"></i></a>

          <a class="btn btn-primary btn-circle" title="Add to Cart" ng-click="addToOrder(fi.MenuItemId)" style="color:white"><i class="fa fa-plus"></i></a>

        </td>

      </tr>

      <h1 ng-show="favoriteItems.length==0" ng-cloak> Empty List ! </h1>

    </tbody>

  </table>

</div>

<?php require('../footer.php'); ?>