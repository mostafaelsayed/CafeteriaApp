<?php

  require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/functions.php');

  validatePageAccess($conn);

  require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Customer/layout.php');

?>

<head>

  <title>Order Checkout</title>

  <link rel="stylesheet" type="text/css" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/map.css">

  <script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/calculate_distance_given_longitude_and_latitude.js"></script>
 
  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/checkout.js"></script>

</head>

<div ng-controller="OrderCheckout" ng-init="phoneDisabled=true" class="container" style="align-content:center;text-align:center">

  <h1 class="page-header" style="text-align:center;margin-top:70px">Complete Order info.</h1>

  <form novalidate name="myForm" action="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php" method="post" style="align-content:center;text-align:center">

    <input type="text" style="visibility:hidden" ng-model="orderId" name="orderId">

    <input type="text" style="visibility:hidden" ng-model="deliveryTimeId" name="deliveryTimeId">

    <input type="text" style="visibility:hidden" ng-model="deliveryPlace" name="deliveryPlace">

    <input type="text" style="visibility:hidden" ng-model="selectedMethod.Id" name="selectedMethodId">

    <input type="text" style="visibility:hidden" ng-model="total" name="total">

    <div class="well" style="width:550px;height:720px;margin:auto;background-color:white">

      <div>Recepient Name</div>

      <div>

        <input type="text" name="recepientName" style="text-align:center" ng-model="recepientName" required />

        <span ng-show="myForm.$submitted && myForm.recepientName.$invalid" ng-cloak>The name is required.</span>

        <br><br><br>

      </div>

      <div>Phone</div>

      <div>

        <input type="text" name="phone" ng-model="phone" style="text-align:center" ng-disabled="phoneDisabled" required />

        <span style="position:absolute;margin-top:3px">

          <input type="checkbox" name="phonecheck" ng-model="phoneDisabled">

          Keep Old

        </span>

        <br><br><br>

      </div>

      <select ng-options="type.name for type in orderTypes" ng-model="selectedType"></select>

      <br><br><br>

      <div ng-show="selectedType.id == 1">

        <div>Delivery Place</div>

        <!-- <div>

          <select name="place" ng-model="selectedLocation" ng-options=" place[1] for place in userLocations"></select>

          <span ng-show="myForm.$submitted && myForm.deliveryPlace.$invalid" ng-cloak>The Delivery Place is required.</span>

          <br><br><br>

        </div> -->

        <div>Delivery Fees</div>

        <div>

          <input type="text" name="deliveryFees" style="text-align:center" ng-model="deliveryFees" disabled />

          <br><br><br>

        </div>

      </div>

      <div>Order Status</div>

      <div>

        <input type="text" name="orderStatus" style="text-align:center" value="Open" disabled />

        <br><br><br>

      </div>

      <div>Discount</div>

      <div>

        <input type="text" name="discount" ng-model="discount" disabled />

        <span style="position:absolute;margin-top:3px">%</span>

        <br><br><br>

      </div>

      <div>Total: &nbsp;

        <span>

          {{ total | currency : "$" : 2 }}

        </span>

      </div>

      <br><br>

      <div>Payment Method</div>

      <div>

        <select name="method" ng-model="selectedMethod" ng-options=" method.Name for method in paymentMethods" required />
       	</select>

        <span ng-show="myForm.$submitted && myForm.method.$invalid" ng-cloak>The Payment Method is required.</span>

      </div>

    </div>

    <br>

    <div class="wrapper">
   
      <div id="map">

        <span class="helper">Click the button below to show your location on the map</span>

      </div>

      <br>

      <a ng-show="my == 0" ng-click="findPlaceLocation(closestPlace.geometry.location,1)" style="display:block;margin:auto;cursor:pointer">Find My Location</a>

      <a ng-show="my == 1" ng-click="findPlaceLocation(closestPlace.geometry.location)" style="display:block;margin:auto;cursor:pointer">Find Closest Location</a>

      <br>

    </div><!--End Wrapper-->

    <input type="submit" class="btn btn-primary" name="next" value="Next" />
    &nbsp;&nbsp;&nbsp;

    <span><input type="submit" class="btn btn-primary" name="cancel" value="Discard Order" ng-click="discardOrder()" /></span>

    <br><br>

  </form>

  <br>

</div>

<?php require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/footer.php'); ?>