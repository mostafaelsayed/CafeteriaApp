<?php
  require(__DIR__.'/../layout.php');
    validatePageAccess([2]);
?>

<head>

  <title>Order Checkout</title>

  <link href="../css/alertify.bootstrap.css" rel="stylesheet">

  <link href="../css/alertify.core.css" rel="stylesheet">
  
  <link href="../css/alertify.default.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="../css/map.css">

  <script src="../js/alertify.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js"></script>

  <script src="../js/calculate_distance_given_longitude_and_latitude.js"></script>
 
  <script src="../js/checkout.js"></script>

</head>

<div ng-controller="OrderCheckout" ng-init="phoneDisabled=true" class="container" style="align-content: center;text-align: center">

  <h1 class="page-header" style="text-align: center;margin-top: 70px">Complete Order info.</h1>

  <form novalidate name="myForm" action="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php" method="post" style="align-content: center;text-align: center">

    <input type="text" style="visibility: hidden" ng-model="selectedMethod.id" name="selectedMethodId">

    <input type="text" style="visibility: hidden" ng-model="selectedType.id" name="orderType">

    <input type="text" style="visibility: hidden" ng-model="total" name="total">

    <div class="well" style="width: 550px;height: 280px;margin: auto;background-color: white">

      <select ng-model="selectedType" ng-options="type.name for type in orderTypes" ng-change="changeType()"></select>

      <!-- <div><button ng-click="changeType()">Confirm Type</button></div> -->

      <br><br><br>

      <div>Total: {{ total }}</div>
        <br/>
        <div ng-show="deliveryFee != 0">Delivery: {{ deliveryFee }}</div>
        <div>Tax: {{ taxFee }}</div>
        <br/>
        <div>SubTotal: {{ subTotal }}</div>
      

      <br><br>

      <div>Payment Method</div>

      <div>

        <select name="method" ng-model="selectedMethod" ng-change="changePaymentMethod()" ng-options="method.name for method in paymentMethods" required />
       	</select>

        <!-- <div><button ng-click="changePaymentMethod()">Confirm Payment Method</button></div> -->

        <span ng-show="myForm.$submitted && myForm.method.$invalid" ng-cloak>The Payment Method is required.</span>

      </div>

    </div>

    <br />

    <input ng-show="selectedMethod.id != 4 && selectedMethod.id != 2" type="submit" class="btn btn-primary" name="next" value="Next" />

    <a type="button" ng-show="selectedMethod.id == 2" href="../Templates/credit-card-payment.php">Next</a>
    &nbsp;&nbsp;&nbsp;

    <input style="position: absolute; display: none" ng-show="selectedMethod.id == 4" type="submit" class="btn btn-primary inbut" name="next" />
    &nbsp;&nbsp;&nbsp;

    <a class="btn btn-primary" ng-show="selectedMethod.id == 3" ng-click="confirmOrder()">Submit</a>&nbsp;

    <a class="btn btn-primary" ng-click="discardOrder()">Discard Order</a>

    <div style="visibility: hidden" class="wrapper">
   
      <div id="map"></div>

      <br />

      <div style="color: white">Click on the map above to Change Your Delivery Location</div>

      <br />

      <a class="btn btn-primary" ng-click="confirmLocation()">Confirm Location</a>&nbsp;

      <a class="btn btn-primary" ng-click="returnToMyCurrentLocation()">Return To My Current Location</a>

      <br /> <br />

    </div><!--End Wrapper-->

    <br><br>

  </form>

  <br>

</div>

<?php require( __DIR__ . '/../Public/footer.php'); ?>