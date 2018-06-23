<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([2, 3]);
?>

<head>
  <title>Order Checkout</title>
  <link href="/css/alertify.bootstrap.css" rel="stylesheet">
  <link href="/css/alertify.core.css" rel="stylesheet">
  <link href="/css/alertify.default.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/css/map.css">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeWPPmdZODmjq3pLXNQVEzPm6X2eZm5dY"></script>
  <script src="/js/calculate_distance_given_longitude_and_latitude.js"></script>
</head>

<div ng-show="subTotal > 0" ng-controller="OrderCheckout" ng-init="phoneDisabled=true" class="container" style="text-align: center;margin: 0 auto">

  <h1 class="page-header" style="margin-top: 70px">
    Complete Order #<span>{{orderId}}</span> info.
  </h1>

  <form id="checkoutForm" novalidate style="margin: 0 auto;border: 3px solid lightgrey;border-radius: 20px;width: 500px" name="myForm" action="/myapi/Order" method="post">
    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token" id="csrf_token">
    <input style="display: none" class="form-control" ng-model="selectedMethod.id" name="selectedMethodId"/>
    <input style="display: none" class="form-control" ng-model="selectedType.id" name="orderType"/>
    <input style="display: none" class="form-control" ng-model="total" name="total"/>
    <br>
    <div>
      <div>Get Order by</div>
      <select class="form-control" style="width: auto" ng-model="selectedType" ng-options="type.name for type in orderTypes" ng-change="changeType()"></select>

      <br>

      <label>Total: {{ total }} $</label>
        <br/>
        <label ng-if="deliveryFee != 0">Delivery: {{ deliveryFee }} $</label>
        <label>Tax: {{ taxFee }} $</label>
        <br/>
        <label>SubTotal: {{ subTotal }} $</label>

      <br><br>

      <div>Payment Method</div>

      <div>
        <select class="form-control" style="width: auto" name="method" ng-model="selectedMethod" ng-change="changePaymentMethod()" ng-options="method.name for method in paymentMethods" required>
       	</select>

        <span ng-if="myForm.$submitted && myForm.method.$invalid" ng-cloak>The Payment Method is required.</span>
      </div>

    </div>

    <br><br>

    <div class="form-group text-center">

      <input type="submit" class="btn btn-primary" ng-if="selectedMethod.id == 1" name="next" value="Next" />

      <a class="btn btn-primary" ng-if="selectedMethod.id == 2" href="/pay/credit">Next</a>

      <a class="btn btn-primary" ng-if="selectedMethod.id == 3" ng-click="confirmOrder()">Submit</a>

      <a class="btn btn-primary" ng-click="discardOrder()">Discard Order</a>

    </div>
    <br><br>
  </form>

  <div class="map-wrapper">
    <!-- <h4>
      Click on the map above to Change Your Delivery Location
    </h4> -->
    <div id="map"></div>
    <br/><br/><br/><br/>

  </div>

  <div ng-show="selectedType.id == 1" class="form-group locBut" style="margin-top: 20px">
    <a class="btn btn-primary confirmLoc" ng-click="confirmLocation()">Confirm Location</a>

    <br><br>    

    <a class="btn btn-primary currLoc" ng-click="returnToMyCurrentLocation()">Return to My Current Location</a>

    <br><br>

    <span ng-bind="formatted_address"></span>
  </div>
</div>

<script src="/js/alertify.js"></script>
<script src="/js/checkout.js"></script>

<?php require(__DIR__ . '/../Public/footer.php'); ?>

<style type="text/css">
  select {
    margin: 0 auto
  }
</style>