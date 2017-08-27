<?php

  require_once("CafeteriaApp.Backend/functions.php"); 
  validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
  if (!isset($_GET["orderId"]) || !isset($_GET["deliveryTimeDuration"]))
  {
    $_GET["orderId"]=0;
    $_GET["deliveryTimeDuration"]=0;
  }
   
?>

<title>Order info</title>

<script src="/CafeteriaApp.Frontend/javascript/review_order_and_charge_customer.js"></script>

<br>

<div ng-controller="reviewOrderAndChargeCustomer" style="align-content:center;text-align:center">

<div style="color: white" class="page-header"><h1>Order #<span ng-bind="orderId"></span></h1></div><br>

<!-- <td>
          Status : Shipped
        </td>
      
        <td>
          Preparation Time within &nbsp; &gt; <span><?php echo "{$_GET["deliveryTimeDuration"]}"; ?></span> &nbsp;Minutes
        </td>
      
        <td>
          Delivered Time within: depends on your location
        </td>
      
        <td>
          Other Fees : i.e. for delivery
        </td>
 -->
  <table align="center" class="table table-bordered" style="width: 600px;height: 120px">

    <thead>

      <tr>

        <th style="color: white">OrderItem Name</th>

        <th style="color: white">OrderItem Unit Price</th>

        <th style="color: white">OrderItem Quantity</th>

        <th style="color: white">OrderItem Total Price</th>

      </tr>

    </thead>

    <tbody>

      <tr ng-repeat="o in orderDetails">

        <td style="color: white" ng-bind="o[0]"></td>
      
        <td style="color: white" ng-bind="o[1]"></td>
      
        <td style="color: white" ng-bind="o[2]"></td>
      
        <td style="color: white" ng-bind="o[3]"></td>

      </tr>

    </tbody>

  </table>

  <label style="color: white">Total : </label><span style="color: white" ng-bind="total"></span><div><br></div>

  <div><label style="color: white">DeliveryPlace :&nbsp;</label><span style="color: white" ng-bind="deliveryPlace"></span></div><br>

  <div style="color: white"><label>Preparation Time within :&nbsp;</label><?php echo "{$_GET["deliveryTimeDuration"]}"; ?></div><br>

  <div style="color: white"><label>Delivered Time within :&nbsp;</label></div><br>

  <form novalidate name="myForm" action="/CafeteriaApp.Backend/Requests/Order.php" method="post" style="align-content:center;text-align:center">
  
    <input type="text" style="visibility: hidden" ng-model="categoryId" name="categoryId">
    <input type="text" style="visibility: hidden" name="orderId" ng-model="orderId">
    <input type="text" style="visibility: hidden" ng-model="paymentId" name="paymentId">
    <input type="text" style="visibility: hidden" ng-model="payerId" name="payerId">
    <input type="text" style="visibility: hidden" ng-model="deliveryTimeId" name="deliveryTimeId">
    <input type="text" style="visibility: hidden" ng-model="deliveryPlace" name="deliveryPlace">
    <input type="text" style="visibility: hidden" ng-model="paymentMethodId" name="paymentMethodId">

    <input type="submit" class="btn btn-primary" value="Pay Now" style="margin: auto;display: block">

  </form>

</div>

<br>