<?php
  require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/functions.php');

  validatePageAccess($conn);

  require('layout.php');

?>

<head>

  <title>Order Checkout</title>

  <link href="../../css/alertify.bootstrap.css" rel="stylesheet">

  <link href="../../css/alertify.core.css" rel="stylesheet">
  
  <link href="../../css/alertify.default.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="../../css/map.css">

  <script src="../../javascript/alertify.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js"></script>

  <script src="../../javascript/calculate_distance_given_longitude_and_latitude.js"></script>
 
  <script src="../../javascript/checkout.js"></script>

</head>

<div ng-controller="OrderCheckout" ng-init="phoneDisabled=true" class="container" style="align-content: center;text-align: center">

  <h1 class="page-header" style="text-align: center;margin-top: 70px">Complete Order info.</h1>

  <form novalidate name="myForm" action="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php" method="post" style="align-content: center;text-align: center">

    <input type="text" style="visibility: hidden" ng-model="selectedMethod.id" name="selectedMethodId">

    <input type="text" style="visibility: hidden" ng-model="selectedType.id" name="orderType">

    <input type="text" style="visibility: hidden" ng-model="total" name="total">

    <div class="well" style="width: 550px;height: 280px;margin: auto;background-color: white">

      <!-- <div>Recepient Name</div>

      <div>

        <input type="text" name="recepientName" style="text-align:center" ng-model="recepientName" required />

        <span ng-show="myForm.$submitted && myForm.recepientName.$invalid" ng-cloak>The name is required.</span>

        <br><br><br>

      </div> -->

      <!-- <div>Phone</div>

      <div>

        <input type="text" name="phone" ng-model="phone" style="text-align:center" ng-disabled="phoneDisabled" required />

        <span style="position:absolute;margin-top:3px">

          <input type="checkbox" name="phonecheck" ng-model="phoneDisabled">

          Keep Old

        </span>

        <br><br><br>

      </div> -->

      <select ng-model="selectedType" ng-options="type.name for type in orderTypes" ng-click="changeType()"></select>

      <br><br><br>

      <!-- <div>Discount</div>

      <div>

        <input type="text" name="discount" ng-model="discount" disabled />

        <span style="position:absolute;margin-top:3px">%</span>

        <br><br><br>

      </div> -->

      <div>Total: &nbsp;

        <span ng-show="(selectedMethod.id == 1 || selectedMethod.id == 5) && selectedType.id == 0">

          {{ totalWithTaxAndShipping | currency : "$" : 2 }}

        </span>

        <span ng-show="selectedMethod.id == 4 && selectedType.id == 0">

          {{ totalWithTax | currency : "$" : 2 }}

        </span>

        <!-- <span ng-show="selectedMethod.id == 4 && selectedType.id == 1">

          {{ totalWithTaxAndShipping | currency : "$" : 2 }}

        </span> -->

        <span ng-show="selectedType.id == 1">

          {{ totalWithShippingTaxAndDelivery | currency : "$" : 2 }}

        </span>

        <br />

        <div>Tax : <span ng-bind="tax"></span></div>

        <div ng-show="selectedType.id == 1">

          <div>Delivery : <span ng-bind="delivery"></span></div>

          <div>Shipping : <span ng-bind="shipping"></span></div>

        </div>

        <div ng-show="(selectedMethod.id == 1 || selectedMethod.id == 5) && selectedType.id == 0">

          <div>shipping : <span ng-bind="shipping"></span></div>

        </div>

        <!-- <div ng-show="selectedType.id == 1">

          <div>Delivery : <span ng-bind="delivery"></span></div>

        </span> -->

      </div>

      <div>Subtotal : <span ng-bind="total"></span></div>

      <br><br>

      <div>Payment Method</div>

      <div>

        <select name="method" ng-model="selectedMethod" ng-options="method.name for method in paymentMethods" required />
       	</select>

        <span ng-show="myForm.$submitted && myForm.method.$invalid" ng-cloak>The Payment Method is required.</span>

      </div>

    </div>

    <br />

<!--     <div ng-show="selectedType.id == 0"> -->

      <input ng-show="selectedMethod.id != 4" type="submit" class="btn btn-primary" name="next" value="Next" />
      &nbsp;&nbsp;&nbsp;

      <input style="position: absolute; display: none" ng-show="selectedMethod.id == 4" type="submit" class="btn btn-primary inbut" name="next" />
      &nbsp;&nbsp;&nbsp;

      <a class="btn btn-primary" ng-click="confirmOrder()">Submit</a>&nbsp;

      <a class="btn btn-primary" ng-click="discardOrder()">Discard Order</a>


      <!-- <span><input type="submit" class="btn btn-primary" name="cancel" value="Discard Order" ng-click="discardOrder()" /></span> -->

    <!-- </div> -->

    <div style="visibility: none" class="wrapper">
   
      <div id="map"></div>

      <br />

      <div style="color: white">Click on the map above to Change Your Delivery Location</div>

      <br />

      <a class="btn btn-primary" ng-click="confirmLocation()">Confirm Location</a>

      <br /> <br />

    </div><!--End Wrapper-->

    <!-- <div ng-show="selectedType.id == 1">

      <input type="submit" class="btn btn-primary" name="next" value="Next" />
      &nbsp;&nbsp;&nbsp;

    </div> -->

    <br><br>

  </form>

  <br>

</div>

<?php require('../footer.php'); ?>