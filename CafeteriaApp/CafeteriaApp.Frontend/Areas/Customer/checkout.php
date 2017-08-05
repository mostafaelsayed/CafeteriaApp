 <title> Order Checkout </title>

<?php
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
  // $_GET["orderId"]
?>

<script src="/CafeteriaApp.Frontend/Scripts/customer/checkout.js"></script>


 <div ng-app="myapp" ng-controller="OrderCheckout" style="align-content:center;text-align:center;">
<h1 class="page-header" style="text-align:center;margin-top:70px">Complete Order info.</h1>


    <!-- <form action="register.php" method="post" style="align-content:center;text-align:center;"> -->
      <p>Recepient Name:
        <input type="text" name="userName" value="" />
      </p>
       <p>Delivery Place:
        <input type="text" name="deliveryPlace" value="" />
      </p>
      <p>Order Status:
        <input type="text" name="orderStatus" value="Open" disabled />
      </p>
      <p>Total:
        <input type="text" name="total" value="" />
      </p>
      <p>E-mail:
        <input type="text" name="email" value="" />
      </p>

      <p>Payment Method:
        <select>
	  <option value="1">Visa</option>
	  <option value="2">Cash</option>
	  <option value="3">Paypal</option>
		</select>

      </p>
      <p>Phone:
      <input type="checkbox" name="vehicle" value="Bike">choose another<br>
  	<!-- <input type="checkbox" name="vehicle" value="Car" checked> I have a car<br> -->
        <input type="text" name="phone" value="" />
      </p>
     
    
      <input type="submit" name="submit" value="Next" />
            <input type="submit" name="cancel" value="Discard Order" ng-click="discardOrder()"  />

      <!-- <a href="manage_admins.php">Cancel</a> -->
    <!-- </form> -->
    <br />

</div>
