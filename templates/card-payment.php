<?php require(__DIR__ . '/../CafeteriaApp/CafeteriaApp.Frontend/layout.php'); ?>


<title>Card Details</title>

<link href="/css/braintree-form.css">

<link href="/css/alertify.bootstrap.css" rel="stylesheet">

<link href="/css/alertify.core.css" rel="stylesheet">

<link href="/css/alertify.default.css" rel="stylesheet">

<link rel="stylesheet" href="/js/bower_components/fakeLoader/fakeLoader.css">

<script src="/js/alertify.js"></script>

<script type="text/javascript" src="/js/bower_components/fakeLoader/fakeLoader.js"></script>

<script src="https://js.braintreegateway.com/web/3.31.0/js/client.min.js"></script>

<script src="https://js.braintreegateway.com/web/3.31.0/js/hosted-fields.min.js"></script>

<script type="text/javascript" src="/js/braintree.js"></script>



<div id="myform" style="display: none" class="panel panel-default bootstrap-basic" ng-controller="braintree">
  <div style="margin-top: 50px;text-align: center;" class="panel-heading">
    <h3 class="panel-title">Enter Card Details</h3>
  </div>

  <div style="margin-top: 50px" id="fakeloader"></div>

  <form style="margin: 0 auto;width: 600px" class="panel-body" method="POST" action="/myapi/Order">
    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token">
    <div>
      <div class="form-group">
        <label class="control-label">Card Number</label>
        <!--  Hosted Fields div container -->
        <div class="form-control" id="card-number"></div>
        <span class="helper-text"/span>
      </div>
      <div class="form-group">
        <div>
          <div><label class="control-label">Expiration Date</label></div>
          <div style="display: inline-block;">
            <!--  Hosted Fields div container -->
            <div class="form-control" id="expiration-month"></div>
          </div>
          <div style="display: inline-block;">
            <!--  Hosted Fields div container -->
            <div class="form-control" id="expiration-year"></div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="form-group">
        <label class="control-label">Security Code</label>
        <!--  Hosted Fields div container -->
        <div class="form-control" id="cvv"></div>
      </div>
      <div class="form-group">
        <label class="control-label">Zipcode</label>
        <!--  Hosted Fields div container -->
        <div class="form-control" id="postal-code"></div>
      </div>
    </div>

    
    <button value="submit" id="submit" class="btn btn-primary btn-lg center-block">Pay with <span id="card-type">Card</span></button>

    <input type="text" name="nonce" ng-model="nonce" style="visibility: hidden;">

    <input type="submit" id="formbut" name="submit" style="visibility: hidden;">
  </form>

  <script type="text/javascript">$("#fakeloader").fakeLoader();</script>
</div>