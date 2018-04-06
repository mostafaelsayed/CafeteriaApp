<?php

  require(__DIR__ . '/../../CafeteriaApp.Backend/functions.php');
  validatePageAccess([2]);
  require(__DIR__ . '/../layout.php');

  if ( !isset($_GET['orderId']) || !isset($_GET['deliveryTimeDuration']) ) {
    $_GET['orderId'] = 0;
    $_GET['deliveryTimeDuration'] = 0;
  }

?>

<head>

  <title>Order info</title>

  <script src="../js/review_order_and_charge_customer.js"></script>

</head>

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

        <!-- <th style="color: white">OrderItem Total Price</th> -->

      </tr>

    </thead>

    <tbody>

      <tr ng-repeat="o in orderDetails">

        <td style="color: white" ng-bind="o[0]"></td>
      
        <td style="color: white" ng-bind="o[1]"></td>
      
        <td style="color: white" ng-bind="o[2]"></td>
      
        <!-- <td style="color: white" ng-bind="o[3]"></td> -->

      </tr>

    </tbody>

  </table>

  <label style="color: white">Total : </label>

  <span style="color: white" ng-bind="total"></span>

  <div><br></div>

  <form novalidate name="myForm" action="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php" method="post" style="align-content: center;text-align: center">

    <input type="text" style="visibility: hidden" ng-model="paymentId" name="paymentId">

    <input type="text" style="visibility: hidden" ng-model="payerId" name="payerId">

    <input type="text" style="visibility: hidden" ng-model="paymentMethodId" name="paymentMethodId">

    <input type="text" style="visibility: hidden" ng-model="orderType" name="orderType">

    <input type="submit" class="btn btn-primary" value="Pay Now" style="margin: auto;display: block">

  </form>

</div>

<br>

<?php require(__DIR__ . '/../Public/footer.php'); ?>