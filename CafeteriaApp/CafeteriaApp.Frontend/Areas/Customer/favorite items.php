<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
   
?>
<title> Favorite Items</title>

<link href="/CafeteriaApp.Frontend/css/normalize.css" rel="stylesheet">
<link href="/CafeteriaApp.Frontend/css/favorite items.css" rel="stylesheet">
<link href="/CafeteriaApp.Frontend/css/popup.css" rel="stylesheet">

<script src="/CafeteriaApp.Frontend/javascript/favorite items.js"></script>
<style type="text/css">
  
.animate-show-hide.ng-hide {
  opacity: 0;
}

.animate-show-hide.ng-hide-add,
.animate-show-hide.ng-hide-remove {
  transition: all linear 1s;
}



</style>
<div class="break"></div>

<div class="col-lg-5"  ng-controller="favorites"  style="text-align:center;position: relative;align-content: center;padding:0px;margin: auto;">

<div  >
  <h2 style="color:orange;" >My Favorites</h2>
  <div class="popup" style="float: right;">
  <span class="popuptext" id="myPopup">A Simple Popup!</span>
</div>
</div>



<table align="center"  class="table" style=" margin-left:70px;" ng-show="favoriteItems.length > 0"  >
        <thead>
          <tr>
            <th id="thead">Name</th>
            <th id="thead">Description</th>
            <th id="thead">Price</th>
            <th id="thead" style="text-align: center;">Image</th>
          </tr>
        </thead>
        <tbody  >
          <tr ng-repeat="fi in favoriteItems">
            <td ng-bind="fi.Name" id="thead"></td>
            <td ng-bind="fi.Description" id="thead"></td>
            <td ng-bind="fi.Price" id="thead"></td>
            <td><img src="{{fi.Image}}"></td>
            <td style="vertical-align: middle;"> 
           
            <a   class="btn btn-primary btn-circle" title="Remove Favorite Item" ng-click="deleteFavorItem(fi.MenuItemId,$index);" style="color:white;" ><i class="fa fa-minus"></i> </a>
            

           <a class="btn btn-primary btn-circle" title="Add to Cart" ng-click="addToOrder(fi.MenuItemId)" style="color:white;" ><i class="fa fa-plus"></i> </a>

            </td>
             
            
          </tr>

          <h1 ng-show="favoriteItems.length==0" class="check-element animate-show-hide"> Empty List ! </h1>
        </tbody>
      </table>
      </div>
<?php require_once("CafeteriaApp.Frontend/Areas/footer.php");
?>
