<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([2]);
?>
<!-- here you can know to which category your user belongs and can recommend him new items in that category -->

<title>Favorite Items</title>
<link href="/css/favorite items.css" rel="stylesheet">
<link href="/css/popup.css" rel="stylesheet">

<div class="container" ng-controller="favorites" style="text-align: center;position: relative">

  <div>

    <h2 style="color: orange;margin-top: 50px"> My Favorites <img style="width: 70px;height: 70px" src="/images/icons/face-savouring-delicious-food.png"></h2>

    <div class="popup" style="position: fixed">
      <span class="popuptext" id="myPopup">A Simple Popup!</span>
    </div>
      

  </div>

  <table class="table" style="margin: auto;color: #891C88" ng-show="favoriteItems.length > 0" ng-cloak>

    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th style="text-align: center">Image</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="fi in favoriteItems">
        <td ng-bind="fi.Name" id="thead"></td>
        <td ng-bind="fi.Description" id="thead"></td>
        <td><img class="img-rounded" src="{{fi.Image}}" style="width: 200px;height: 200px"></td>
        <td style="vertical-align: middle"> 
          <a class="btn btn-default btn-circle" title="Remove Favorite Item" ng-click="deleteFavorItem(fi.MenuItemId,$index);" style="color: red"><i class="fa fa-minus"></i></a>

          <a class="btn btn-primary btn-circle" style="width: 70px;height: 70px" title="Add to Cart" ng-click="addToOrder(fi.MenuItemId)"> <img src="/images/icons/cart-favo.png" style="width: 100%;height: 100%"/></a>
        </td>
      </tr>

      <h1 ng-show="favoriteItems.length==0" ng-cloak> Empty List ! </h1>

    </tbody>

  </table>

</div>

<script src="/js/favorite items.js"></script>

<?php require(__DIR__ . '/../Public/footer.php'); ?>