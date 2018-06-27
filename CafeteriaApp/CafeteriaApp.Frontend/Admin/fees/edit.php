<?php
	require(__DIR__ . '/../layout.php');
  validatePageAccess([1]);
?>

<head>

	<title>Managing Fee</title>

</head>

<div class="row">

  <h1 class="page-header">Edit Fee</h1>

</div>

<div class="row" ng-app="edit_fee" ng-controller="editFee">

	<div class="row">

  	<form novalidate role="form" name="myform" id="centerBlock">

      <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token" id="csrf_token">

      <div class="form-group">

        <label>Fee Name</label>

        <input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" required />

    		<span ng-show="myform.name.$touched && myform.name.$invalid" id="inputControl" ng-cloak>

    			Fee Name is Required

    			<br>

    		</span>

        <br>

        <div><label>Price</label></div>

    		<input id="inputField" type="text" class="form-control" autofocus="autofocus" number-check ng-model="price" name="price" required/>

    		<span ng-show="myform.price.$touched && myform.price.$error.numberEmpty" id="inputControl" ng-cloak>

    			Price is Required

    		</span>

    		<span ng-show="myform.price.$touched && myform.price.$error.numberCheck" id="inputControl" ng-cloak>

    			Price is invalid.it must be a number of at most 9 digits and optinally followed by at most 2 digit

    			<br>

    		</span>

      </div>

      <div class="form-group">

        <input type="submit" value="save" class="btn btn-primary" ng-click="editFee()">

      </div>

    </form>

	</div>

</div>

<script src="/js/edit_fee.js"></script>
<script src="/js/price_module.js"></script>