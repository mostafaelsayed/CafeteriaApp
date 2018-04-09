<?php

require(__DIR__ . '/../layout.php');
validatePageAccess([2]);

?>


<title>Order info</title>

<br>

<div ng-controller="reviewOrderAndChargeCustomer" class="container" style="align-content: center;text-align: center">

  <div style="color: white" class="page-header">

    <h1>Order #<span ng-bind="orderId"></span></h1>

  </div>

  <br>

  <table align="center" class="table table-bordered" style="width: 600px;height: 120px">

    <thead>

      <tr>

        <th style="color: white">OrderItem Name</th>
        <th style="color: white">OrderItem Unit Price</th>
        <th style="color: white">OrderItem Quantity</th>
        <th style="color: white">OrderItem Total Price</th>
        <!-- <th style="color: white">OrderItem Total Price</th> -->

      </tr>

    </thead>

    <tbody>

      <tr ng-repeat="o in orderItems">

        <td style="color: white" ng-bind="o['Name']"></td>
        <td style="color: white" ng-bind="o['Price']"></td>
        <td style="color: white" ng-bind="o['Quantity']"></td>
        <td style="color: white" ng-bind="o['TotalPrice']"></td>

      </tr>

    </tbody>

  </table>

 <div style="color: white">SubTotal: {{ subTotal }}</div>
 <br/>
 <div style="color: white" ng-show="deliveryFee != 0">
 Delivery: {{ deliveryFee }}</div>
 <br/>
  <div style="color: white">Tax: {{ taxFee }}</div>
   <br/>
  <div style="color: white">Total: {{ total }}</div>
  <br/>
  
  
  <div></div>

  <form novalidate name="myForm" action="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php" method="post" style="align-content: center;text-align: center">

    <input type="text" style="visibility: hidden" ng-model="paymentId" name="paymentId">

    <input type="text" style="visibility: hidden" ng-model="payerId" name="payerId">

    <input type="text" style="visibility: hidden" ng-model="paymentMethodId" name="paymentMethodId">

    <input type="text" style="visibility: hidden" ng-model="orderType" name="orderType">

    <input type="submit" class="btn btn-primary" value="Pay Now" style="margin: auto;display: block">

  </form>

</div>

<script src="../js/review_order_and_charge_customer.js"></script>

<?php require(__DIR__ . '/../Public/footer.php'); ?>