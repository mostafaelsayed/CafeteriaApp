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
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeWPPmdZODmjq3pLXNQVEzPm6X2eZm5dY"></script>
<script src="../js/calculate_distance_given_longitude_and_latitude.js"></script>
</head>

<div ng-controller="OrderCheckout" ng-init="phoneDisabled=true" class="container" style="align-content: center;text-align: center">

  <h1 class="page-header" style="text-align: center;margin-top: 70px">
  Complete Order #<span>{{orderId}}</span> info.
  </h1>

  <form novalidate name="myForm" action="../../CafeteriaApp.Backend/Requests/Order.php" method="post" style="text-align:left;color:white;background-color:#A52A2A;border-radius:20px;">
    <input type="hidden" class="form-control"   ng-model="selectedMethod.id" name="selectedMethodId"/>
    <input type="hidden" class="form-control"  ng-model="selectedType.id" name="orderType"/>
    <input type="hidden" class="form-control"  ng-model="total" name="total"/>
    <br>
    <div style="width: 550px;margin:auto;">
      <div>Get Order by</div>
      <select class="form-control" ng-model="selectedType" ng-options="type.name for type in orderTypes" ng-change="changeType()"></select>

      <!-- <div><button ng-click="changeType()">Confirm Type</button></div> -->

      <br><br><br>

      <label>Total: {{ total }} $</label>
        <br/>
        <label ng-show="deliveryFee != 0">Delivery: {{ deliveryFee }} $</label>
        <label>Tax: {{ taxFee }} $</label>
        <br/>
        <label>SubTotal: {{ subTotal }} $</label>

      <br><br>

      <div>Payment Method</div>

      <div>
        <select class="form-control" name="method" ng-model="selectedMethod" ng-change="changePaymentMethod()" ng-options="method.name for method in paymentMethods" required />
       	</select>

        <span ng-show="myForm.$submitted && myForm.method.$invalid" ng-cloak>The Payment Method is required.</span>
      </div>

    </div>

    <br />
   
      <div class="map-wrapper">
        <h4 style="text-align:center;">
          Click on the map above to Change Your Delivery Location
        </h4>
      <div id="map"></div>
      <br/>
      <br/>
      <div class="form-group text-center">
        <a class="btn btn-primary" ng-click="confirmLocation()">Confirm Location</a>

        <a class="btn btn-primary" ng-click="returnToMyCurrentLocation()">Return To My Current Location</a>
      </div>
      <br /> <br />

    </div><!--End Wrapper-->

    <br><br>
    <div class="form-group text-center">
      <input type="submit" class="btn btn-primary" ng-show="selectedMethod.id == 1"   name="next" value="Next" />

      <a  type="button" class="form-control" ng-show="selectedMethod.id == 2" href="../Templates/credit-card-payment.php">Next</a>


      <a class="btn btn-primary" ng-show="selectedMethod.id == 3" ng-click="confirmOrder()">Submit</a>

      <a class="btn btn-primary" ng-click="discardOrder()">Discard Order</a>
    </div>
    <br><br>
  </form>


</div>
<script src="../js/alertify.js"></script>
<script src="../js/checkout.js"></script>
<script src="../js/bootstrap.min.js"></script>
<?php require( __DIR__ . '/../Public/footer.php'); ?>