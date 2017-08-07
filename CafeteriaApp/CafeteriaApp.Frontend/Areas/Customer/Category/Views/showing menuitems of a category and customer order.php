<title>MenuItems</title>

<?php
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
?>

<script src="/CafeteriaApp.Frontend/Scripts/customer/showing menuitems of a category and customer order.js"></script>
<link href="/CafeteriaApp.Frontend/Scripts/CustomerTheme/customer styles.css" rel="stylesheet">

<h1 style="margin-top:70px">MenuItems</h1>

<div class="row" ng-app="myapp" ng-controller="getMenuItemsAndCustomerOrder">

    <div class="col-lg-2">
      <a href="#" style="color:white;margin-left:40px">Back</a>
      <br><br>
      <a href="#" style="color:white;margin-left:40px">About This category</a>
    </div>

    <div class="col-lg-5">
      <div ng-repeat="m in menuItems" style="width:90%;margin-left:40px">
        <h1 ng-bind="m.Name" class="menu-name"></h1>
        <a title="Add To Order" id="creatNewCafeteria" ng-click="addToOrder(m)" class="btn btn-circle" style="color:white;margin-left:140px;margin-top:-40px"><i class="fa fa-plus"></i></a>
        <div style="color:white;font-style:italic">Name:  <span ng-bind="m.Name" style="color:white"></span></div>
        <div style="color:white;font-style:italic">Price:  <span ng-bind="m.Price" style="color:white"></span></div>
        <div style="color:white;font-style:italic">Description:  <span ng-bind="m.Description" style="color:white"></span></div>
        <div ng-show="menuItems.indexOf(m)<menuItems.length-1"><hr width="100%"></div>
      </div>
      <br>
    </div>

    <div class="col-lg-5" style="margin-left:-10px">
      <table class="table table-bordered" ng-show="orderItems.length > 0"  >
        <thead>
          <tr>
            <th id="thead">OrderItem</th>
            <th id="thead">Quantity</th>
            <th id="thead">Total Price</th>
            <th id="thead">Actions</th>
          </tr>
        </thead>
        <tbody ng-repeat="o in orderItems" >
          <tr>
            <td ng-bind="o.Name" id="thead"></td>
            <td ng-bind="o.Quantity" id="thead"></td>
            <td ng-bind="o.TotalPrice" id="thead"></td>
            <td ng-show="orderItems.length>0">
              <a title="Increase Quantity" id="creatNewCafeteria" ng-click="increaseQuantity(o)" class="btn"><i class="fa fa-plus"></i></a>
              <a title="Decrease Quantity" id="creatNewCafeteria" ng-click="decreaseQuantity(o)" class="btn"><i class="fa fa-minus"></i></a>
              <a title="Remove From Order" ng-click="deleteOrderItem(o)" style="color:white;font-style:italic" class="btn">Remove This Item</a>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- <div id="thead">Total: <span ng-bind="currentOrder.Total"></span></div> -->
      <div><a style="font-style:italic;color:white;" class="btn" type="button" ng-href="/CafeteriaApp.Frontend/Areas/Customer/checkout.php?orderId={{orderId}}"  ng-show="orderItems.length > 0"  target="_self"  >Checkout</a></div>
    </div>

  <hr width="80%">
  <h1>About This Category</h1><br>
  <h3>we have special menuitems here with affordable price.Take a look at our dishes and have fun!</h3>

</div>
