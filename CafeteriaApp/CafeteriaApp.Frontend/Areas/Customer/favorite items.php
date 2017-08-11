<title> Favorite Items</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
   
?>
<script src="/CafeteriaApp.Frontend/javascript/myapp.js"></script>

<script src="/CafeteriaApp.Frontend/javascript/favorite items.js"></script>
<link href="/CafeteriaApp.Frontend/css/customer styles.css" rel="stylesheet">

<br>
<div class="col-lg-5" ng-app="myapp" ng-controller="favorites"  style="align-content:center;text-align:center;">


<table align="center"  class="table" style=" margin:20px;" ng-show="favoriteItems.length > 0"  >
        <thead>
          <tr>
            <th id="thead">Name</th>
            <th id="thead">Description</th>
            <th id="thead">Price</th>
            <th id="thead" style="text-align: center;">Image</th>
          </tr>
        </thead>
        <tbody ng-repeat="fi in favoriteItems" >
          <tr>
            <td ng-bind="fi.Name" id="thead"></td>
            <td ng-bind="fi.Description" id="thead"></td>
            <td ng-bind="fi.Price" id="thead"></td>
            <td><img src="{{fi.Image}}"></td>
            <td> <a class="btn" title="Remove Favorite Item" ng-click="deleteFavorItem(fi.Id)" style="color:white;font-style:italic" class="btn"><i class="fa fa-minus"></i> </a></td>
             
            
          </tr>

          <h1 ng-show="favoriteItems.length==0"> Empty List ! </h1>
        </tbody>
      </table>
      </div>

      <!-- </body> -->