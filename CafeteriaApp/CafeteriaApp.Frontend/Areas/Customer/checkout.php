<?php

  require_once("CafeteriaApp.Backend/functions.php"); 
  validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');

?>

<title>Order Checkout</title>

<script src="/CafeteriaApp.Frontend/javascript/checkout.js"></script>

<div ng-controller="OrderCheckout" ng-init="phoneDisabled=true" style="align-content:center;text-align:center;">

  <h1 class="page-header" style="text-align:center;margin-top:70px">Complete Order info.</h1>

  <form novalidate name="myForm" action="/CafeteriaApp.Backend/Requests/Order.php" method="post" style="align-content:center;text-align:center">

    <input type="text" style="visibility: hidden" ng-model="orderId" name="orderId">
    <input type="text" style="visibility: hidden" ng-model="categoryId" name="categoryId">
    <input type="text" style="visibility: hidden" ng-model="deliveryTimeId" name="deliveryTimeId">
    <input type="text" style="visibility: hidden" ng-model="deliveryPlace" name="deliveryPlace">
    <input type="text" style="visibility: hidden" ng-model="selectedMethod.Id" name="selectedMethodId">
    <input type="text" style="visibility: hidden" ng-model="total" name="total">

    <div class="well" style="width: 550px;height: 720px;margin: auto;background-color: white">

      <div>Recepient Name</div>

      <div>

        <input type="text" name="recepientName" style="text-align: center" ng-model="recepientName" required />
        <span ng-show=" myForm.$submitted  && myForm.recepientName.$invalid" >The name is required.</span>
        <br><br><br>

      </div>

      <div>Phone</div>

      <div>

        <input type="text" name="phone" ng-model="phone" style="text-align: center" ng-disabled="phoneDisabled" required/>
        <span style="position: absolute;margin-top: 3px"><input type="checkbox" name="phonecheck" ng-model="phoneDisabled">Keep Old</span>
        <br><br><br>

      </div>

      <select ng-options="type.name for type in orderTypes" ng-model="selectedType"></select>
      <br><br><br>

      <div ng-show="selectedType.id == 1">

        <div>Delivery Place</div>

        <div>

          <select name="place" ng-model="selectedLocation" ng-options=" place[1] for place in userLocations">
          </select>
          <span ng-show=" myForm.$submitted  && myForm.deliveryPlace.$invalid">The Delivery Place is required.</span>
          <br><br><br>

        </div>

        <div>Delivery Fees</div>

        <div>

          <input type="text" name="deliveryFees" style="text-align: center" ng-model="deliveryFees" disabled />
          <br><br><br>

        </div>

      </div>

      <div>Order Status</div>

      <div>

        <input type="text" name="orderStatus" style="text-align: center" value="Open" disabled />
        <br><br><br>

      </div>

      

      <div>Discount</div>

      <div>

        <input type="text" name="discount" ng-model="discount" disabled /> <span style="position: absolute;margin-top: 3px">%</span>
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

        <select  name="method"  ng-model="selectedMethod"  ng-options=" method.Name for method in paymentMethods" required>
       	</select>
        <span ng-show=" myForm.$submitted && myForm.method.$invalid">The Payment Method is required.</span>

      </div>

    </div>

    <br>

    <div ng-show="selectedType.id == 1">

      <div class="wrapper">
     
        <div id="map">

            <span class="helper">Click the button below to show your location on the map</span>
            <!-- <img id="preloader" src="/CafeteriaApp.Frontend/images/bann_sep.png"> -->

        </div>

        <br>

        <a ng-click="currentLocation()" style="display: block;margin: auto;cursor: pointer">Find My Location</a>

        <br>

       <!--  <div id="results"> -->

            <!-- <span class="longitude"></span><br>
            <span class="lattitude"></span><br>
            <span class="location"></span> -->

        <!-- </div> -->
         
      </div><!--End Wrapper-->
      
    </div>

    <input type="submit" name="next" value="Next" ng-disabled="myForm.$invalid" />

    <br><br>   
        <!-- <a href="manage_admins.php">Cancel</a> -->
  </form>

  <input type="submit" name="cancel" value="Discard Order" ng-click="discardOrder()" />

  <br>

  <!-- <div id="map"></div> -->
  <link rel="stylesheet" type="text/css" href="/CafeteriaApp.Frontend/css/map.css">

  <script src="/CafeteriaApp.Frontend/javascript/show_location.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

</div>


<?php require_once("CafeteriaApp.Frontend/Areas/footer.php");
?>