<?php
	require(__DIR__ . '/../layout.php');
	validatePageAccess([3]);
	require(__DIR__ . '/../modal_includes.php');
?>

<title>Order Details</title>

<head>

	<link rel="stylesheet" type="text/css" href="/css/map.css">

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeWPPmdZODmjq3pLXNQVEzPm6X2eZm5dY"></script>

	<script src="/js/show_order_details.js"></script>

</head>

<div ng-app="order_details">

	<div ng-controller="order_details" style="margin-top: 40px" ng-cloak>

		<h2 style="text-align: center">Order Details</h2>

		<table class="table table-bordered" ng-cloak>

        	<thead>

          		<tr>

            		<th id="thead">Id</th>

            		<th id="thead">UserId</th>

            		<th id="thead">Total</th>

            		<th id="thead">Type</th>

          		</tr>

        	</thead>

	        <tbody>

	          <tr>

	            <td ng-bind="orderDetails.Id" id="thead"></td>

	            <td ng-bind="orderDetails.UserId" id="thead"></td>

	            <td ng-bind="orderDetails.Total" id="thead"></td>

	            <td ng-show="orderDetails.Type == 1">Delivery</td>

	            <td ng-show="orderDetails.Type == 0">TakeAway</td>

	          </tr>

	        </tbody>

    	</table>

    	<br /><br />

    	<h2 style="text-align: center">OrderItems Details</h2>

    	<table class="table table-bordered" ng-cloak>

        	<thead>

          		<tr>

            		<th id="thead">Name</th>

            		<th id="thead">Quantity</th>

            		<th id="thead">Price</th>

          		</tr>

        	</thead>

	        <tbody ng-repeat="o in orderItems">

	        	<tr>

	        		<td ng-bind="o.Name" id="thead"></td>

	        		<td ng-bind="o.Quantity" id="thead"></td>

	       			<td ng-bind="o.TotalPrice" id="thead"></td>

	        	</tr>

	        </tbody>

    	</table>

    	<div ng-show="orderDetails.Type == 1">

    		<h2 style="text-align: center">Order Location</h2>

    		<div class="wrapper"><div id="map" style="width: 500px;height: 500px"></div></div>

    		<br>

    	</div>

	</div>

</div>