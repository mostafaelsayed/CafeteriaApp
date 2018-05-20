<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([2, 3]);
?>

<title>Order info</title>

<br>

<div ng-controller="reviewOrderAndChargeCustomer" class="container" style="align-content: center;text-align: center">

  <div class="page-header">

    <h1>Order #<span ng-bind="orderId"></span></h1>

  </div>

  <br>

  <table align="center" class="table table-bordered" style="width: 600px;height: 120px">

    <thead>

      <tr>
        <th>OrderItem Name</th>
        <th>OrderItem Unit Price</th>
        <th>OrderItem Quantity</th>
        <th>OrderItem Total Price</th>
      </tr>

    </thead>

    <tbody>

      <tr ng-repeat="o in orderItems" style="font-size: 17px">

        <td ng-bind="o['Name']"></td>
        <td ng-bind="o['Price']"></td>
        <td ng-bind="o['Quantity']"></td>
        <td ng-bind="o['TotalPrice']"></td>

      </tr>

    </tbody>

  </table>

  <div class="detail">
    <div>SubTotal: {{ subTotal }}</div>

    <br/>

    <div ng-if="deliveryFee != 0">

      Delivery: {{ deliveryFee }}

    </div>

    <div>Tax: {{ taxFee }}</div>

    <br/><br/>

    <div>Total: {{ total }}</div>
  </div>

  <br/>
  
  <div></div>

  <form novalidate name="myForm" action="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php" method="post" style="align-content: center;text-align: center">

    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token" id="csrf_token">

    <input type="text" style="visibility: hidden" ng-model="paymentId" name="paymentId">

    <input type="text" style="visibility: hidden" ng-model="payerId" name="payerId">

    <input type="submit" class="btn btn-primary" value="Pay Now" style="margin: auto;display: block">

  </form>

</div>

<style type="text/css">
  .detail {
    font-size: 17px
  }
</style>

<script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/review_order_and_charge_customer.js"></script>

<?php require(__DIR__ . '/../Public/footer.php'); ?>