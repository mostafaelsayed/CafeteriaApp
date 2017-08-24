 <?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
  // $_GET["orderId"]
?>
 <title> Order Checkout </title>

<script src="/CafeteriaApp.Frontend/javascript/checkout.js"></script>


 <div  ng-controller="OrderCheckout" ng-init="phoneDisabled=true" style="align-content:center;text-align:center;">
<h1 class="page-header" style="text-align:center;margin-top:70px">Complete Order info.</h1>


    <form novalidate name="myForm" action="/CafeteriaApp.Backend/Requests/Order.php" method="post" style="align-content:center;text-align:center;">
    <input type="text" style="visibility: hidden" ng-model="orderId" name="orderId">
    <input type="text" style="visibility: hidden" ng-model="categoryId" name="categoryId">
    <input type="text" style="visibility: hidden" ng-model="deliveryTimeId" name="deliveryTimeId">
    <input type="text" style="visibility: hidden" ng-model="deliveryPlace" name="deliveryPlace">
    <input type="text" style="visibility: hidden" ng-model="selectedMethod.Id" name="selectedMethodId">
    <input type="text" style="visibility: hidden" ng-model="total" name="total">
      <p>Recepient Name:
        <input type="text" name="recepientName"  ng-model="recepientName" required />
        <span ng-show=" myForm.$submitted  && myForm.recepientName.$invalid" >The name is required.</span>
      </p>
      {{myForm.$submitted}}
      <p>Phone:
      <input type="checkbox" name="phonecheck"  ng-model="phoneDisabled" >Keep Old<br>
    
        <input type="text" name="phone" ng-model="phone" ng-disabled="phoneDisabled" required/>
      </p>
       <p>Delivery Place:
        <input type="text" name="deliveryPlace" ng-model="deliveryPlace" placeholder="where to deliver ?" required/>
         <span ng-show=" myForm.$submitted  && myForm.deliveryPlace.$invalid">The Delivery Place is required.</span>
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
        <!-- <input type="text" name="total" ng-model="total" disabled /> -->
        {{ total | currency : "$" : 2 }}
      </p>

     <!--  <p>E-mail:
        <input type="text" name="email" value="" />
      </p> -->

      <p>Payment Method:
        <select  name="method"  ng-model="selectedMethod"  ng-options=" method.Name for method in paymentMethods" required>
       
    <!-- <option value="0"></option> -->
		</select>
     <span ng-show="  myForm.$submitted && myForm.method.$invalid">The Payment Method is required.</span>
      </p>
      <!-- </div> -->
      <input type="submit" name="next" value="Next" ng-disabled="myForm.recepientName.$invalid||myForm.deliveryPlace.$invalid||myForm.method.$invalid||myForm.phone.$invalid"  ng-click="closeOrder()" />      
      <!-- <a href="manage_admins.php">Cancel</a> -->
    </form>


     <input type="submit" name="cancel" value="Discard Order" ng-click="discardOrder()" />
    <br />

</div>
