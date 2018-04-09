<?php require(__DIR__ . '/../layout.php'); ?>
<link href="../css/braintree-form.css">

<link rel="stylesheet" href="../bower_components/fakeLoader/fakeLoader.css">

<script src="https://js.braintreegateway.com/web/3.31.0/js/client.min.js"></script>

<script src="https://js.braintreegateway.com/web/3.31.0/js/hosted-fields.min.js"></script>

<script type="text/javascript" src="../js/braintree.js"></script>

<script type="text/javascript" src="../bower_components/fakeLoader/fakeLoader.js"></script>

<div id="fakeLoader"></div>

<div class="panel panel-default bootstrap-basic" ng-controller="braintree">
  <div class="panel-heading">
    <h3 class="panel-title">Enter Card Details</h3>
  </div>
  <form class="panel-body">
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
  </form>
</div>
