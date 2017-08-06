 <title> Order Checkout </title>

<?php
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
  // $_GET["orderId"]
?>

<script src="/CafeteriaApp.Frontend/Scripts/customer/checkout.js"></script>


 <div ng-app="myapp" ng-controller="OrderCheckout" ng-init="phoneDisabled=true" style="align-content:center;text-align:center;">
<h1 class="page-header" style="text-align:center;margin-top:70px">Complete Order info.</h1>


    <!-- <form action="" method="post" style="align-content:center;text-align:center;"> -->

      <p>Recepient Name:
        <input type="text" name="recepientName"  ng-model="recepientName" />
      </p>
      <p>Phone:
      <input type="checkbox" name="vehicle"  ng-model="phoneDisabled">Keep Old<br>
    
        <input type="text" name="phone" ng-model="phone" ng-disabled="phoneDisabled" />
      </p>
       <p>Delivery Place:
        <input type="text" name="deliveryPlace" placeholder="where to deliver ?" />
      </p>
      <p>Order Status:
        <input type="text" name="orderStatus" value="Open" disabled />
      </p>
      <p>Delivery Fees:
        <input type="text" name="deliveryFees" ng-model="deliveryFees" disabled />
      </p>
      <div>
      <p>Discount:
        <input type="text" name="discount" ng-model="discount" disabled /> <span>%</span>
        </p>
      </div>

      <br>
         <hr>
        <br>

      <p>Total:
        <input type="text" name="total" ng-model="total" disabled />
      </p>

     <!--  <p>E-mail:
        <input type="text" name="email" value="" />
      </p> -->

      <p>Payment Method:
        <select   ng-model="selectedMehod"  ng-options=" mehod.Name for mehod in paymentMethods">
    <!-- <option value="0"></option>
	  <option value="1">Cash on Delivery</option>
	  <option value="2">Visa</option>
	  <option value="3">Online Bank</option> -->
		</select>
      </p>
      
     
    
      <input type="submit" name="submit" value="Next" ng-click="closeOrder()" />
            <input type="submit" name="cancel" value="Discard Order" ng-click="discardOrder()" />

      <!-- <a href="manage_admins.php">Cancel</a> -->
    <!-- </form> -->
    <br />

</div>
