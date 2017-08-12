<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
   
?>
<title> Favorite Items</title>



<script src="/CafeteriaApp.Frontend/javascript/favorite items.js"></script>
<link href="/CafeteriaApp.Frontend/css/customer styles.css" rel="stylesheet">

<br>
<div class="col-lg-5"  ng-controller="favorites"  style="align-content:center;text-align:center;">
<h2   style=" color:orange;text-align:center;margin-top: 50px;">My Favorites</h2>

<table align="center"  class="table" style=" margin:30px;" ng-show="favoriteItems.length > 0"  >
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
            <td> <a class="btn btn-primary btn-circle" title="Remove Favorite Item" ng-click="deleteFavorItem(fi.Id)" style="color:white;font-style:italic" class="btn"><i class="fa fa-minus"></i> </a></td>
             
            
          </tr>

          <h1 ng-show="favoriteItems.length==0"> Empty List ! </h1>
        </tbody>
      </table>
      </div>

      <!-- </body> -->