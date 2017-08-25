<?php

	require_once("CafeteriaApp.Backend/functions.php"); 
   	validatePageAccess($conn);
	require_once('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<head>

	<title>Managing Fee</title>
	<script src="/CafeteriaApp.Frontend/javascript/edit_fee.js"></script>
	<script src="/CafeteriaApp.Frontend/javascript/modal_controller.js"></script>
	<script src="/CafeteriaApp.Frontend/javascript/modal.js"></script>

</head>

<div class="row">
    <div>
      	<h1 class="page-header">Edit Fee</h1>
    </div>
</div>

<div class="row" ng-app="myapp" ng-controller="editFee">
    <div>
      	<div>
        	<div class="row">
            	<div>
              		<form novalidate role="form" name="myform" id="centerBlock">

		          		<div class="form-group">

		            		<label>Fee Name</label>
		            		<input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" required/>
		            		<span ng-show="myform.name.$invalid" id="inputControl">Fee Name is Required<br></span><br>

		            		<div><label>Price</label></div>
		            		<input id="inputField" type="text" class="form-control" autofocus="autofocus" ng-model="price" number-check name="price" required/>
		            		<span ng-show="myform.price.$error.numberEmpty" id="inputControl">Price is Required</span>
		            		<span ng-show="myform.price.$error.numberCheck" id="inputControl">Price is invalid.it must be a number of at most 9 digits and optinally followed by at most 2 digit<br></span>

		          		</div>

		          		<div class="form-group">
		            		<input type = "submit" value = "save" class="btn btn-primary" ng-click="editFee()">
		          		</div>

		      		</form>
          		</div>
        	</div>
      	</div>
    </div>
</div>