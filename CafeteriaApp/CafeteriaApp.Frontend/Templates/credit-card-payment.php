<?php require(__DIR__ . '/../layout.php'); ?>

<link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/braintree-form.css">

<link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/alertify.bootstrap.css" rel="stylesheet">

<link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/alertify.core.css" rel="stylesheet">

<link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/alertify.default.css" rel="stylesheet">

<script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/alertify.js"></script>

<script src="https://js.braintreegateway.com/web/3.31.0/js/client.min.js"></script>

<script src="https://js.braintreegateway.com/web/3.31.0/js/hosted-fields.min.js"></script>

<script type="text/javascript" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/braintree.js"></script>

<div id="myform" style="display: none" class="panel panel-default bootstrap-basic" ng-controller="braintree">
  <div class="panel-heading">
    <h3 class="panel-title">Enter Card Details</h3>
  </div>
  <form style="margin-top: 50px" class="panel-body" method="POST" action="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php">
    <div class="row">
      <div class="form-group col-sm-8">
        <label class="control-label">Card Number</label>
        <!--  Hosted Fields div container -->
        <div class="form-control" id="card-number"></div>
        <span class="helper-text"></span>
      </div>
      <div class="form-group col-sm-4">
        <div class="row">
          <label class="control-label col-xs-12">Expiration Date</label>
          <div class="col-xs-6">
            <!--  Hosted Fields div container -->
            <div class="form-control" id="expiration-month"></div>
          </div>
          <div class="col-xs-6">
            <!--  Hosted Fields div container -->
            <div class="form-control" id="expiration-year"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-sm-6">
        <label class="control-label">Security Code</label>
        <!--  Hosted Fields div container -->
        <div class="form-control" id="cvv"></div>
      </div>
      <div class="form-group col-sm-6">
        <label class="control-label">Zipcode</label>
        <!--  Hosted Fields div container -->
        <div class="form-control" id="postal-code"></div>
      </div>
    </div>

    
    <button value="submit" id="submit" class="btn btn-info btn-lg center-block">Pay with <span id="card-type">Card</span></button>

    <input type="text" name="nonce" ng-model="nonce" style="visibility: hidden;">

    <input type="submit" id="formbut" name="submit" style="visibility: hidden;">
  </form>
</div>