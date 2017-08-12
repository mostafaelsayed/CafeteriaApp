<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
   
?>
<title>Order info</title>

<?php

  if (!isset($_GET["orderId"]) || !isset($_GET["deliveryTimeDuration"]))
  {
	 $_GET["orderId"]=0;
	 $_GET["deliveryTimeDuration"]=0;
  }

?>

<script src="/CafeteriaApp.Frontend/javascript/checkout2.js"></script>

<br>
<div  ng-controller="OrderCheckout2" ng-init=<?php echo "orderno={$_GET["orderId"]}" ?>  style="align-content:center;text-align:center;">

  <table align="center" >
    <thead>
      <tr>
        <th><h1>Order #<span ng-bind="orderno"></span></h1></th>
      </tr>
    </thead>
    <tbody >
      <tr>
        <td>
          Name :<span ng-bind="name"></span>
        </td>
      </tr>
      <tr>
        <td>
          Status : Shipped
        </td>
      </tr>
      <tr>
        <td>
          Preparation Time within &nbsp; &gt; <span><?php echo "{$_GET["deliveryTimeDuration"]}"; ?></span> &nbsp;Minutes
        </td>
      </tr>
      <tr>
        <td>
          Delivered Time within: depends on your location
        </td>
      </tr>
      <tr>
        <td>
          Other Fees : i.e. for delivery
        </td>
      </tr>
    </tbody>
  </table>
</div>
<br>
    
<!-- <div id="map"></div> -->
<link rel="stylesheet" type="text/css" href="/CafeteriaApp.Frontend/css/map.css">
<!-- <script src="/CafeteriaApp.Frontend/javascript/googleMaps.js"></script>-->
 
 <div class="wrapper">
 
    <div id="map">
        <span class="helper">Click the button below to show your location on the map</span>
        <img id="preloader" src="/CafeteriaApp.Frontend/images/bann_sep.png">
    </div>
 
    <a class="button" href="" title="">Find My Location</a>
 
    <div id="results">
        <span class="longitude"></span><br>
        <span class="lattitude"></span><br>
        <span class="location"></span>
    </div>
     
  </div><!--End Wrapper-->
<script src="/CafeteriaApp.Frontend/javascript/showLocation.js"></script>
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeWPPmdZODmjq3pLXNQVEzPm6X2eZm5dY&callback=initMap">
</script> -->