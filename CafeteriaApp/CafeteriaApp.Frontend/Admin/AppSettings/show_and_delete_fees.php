<?php

	require(__DIR__.'/../../../CafeteriaApp.Backend/functions.php');

  //validatePageAccess($conn);

	require(__DIR__.'/../layout.php');

  require(__DIR__.'/../modal_includes.php'); // why not relative ???

?>

<head>

	<title>Fees</title>

	<script src="../../js/show_and_delete_fees.js"></script>

</head>

<div class="row">

  <h1 class="page-header">Fees</h1>

</div>

<div class="row" ng-app="show_and_delete_fees" ng-controller="showAndDeleteFees">

  <div style="margin: auto">

    <div><h3>Manage Your Fees</h3></div>

  	<table width="50%" class="table" style="border-collapse: collapse" border="0" cellspacing="0" cellpadding="0">

      <thead>

        <tr>

          <th id="alignText">Fee Name</th>

          <th id="alignText">Fee Price</th>

          <th id="alignText">Actions</th>

        </tr>

      </thead>

      <tbody ng-repeat="f in fees">

        <tr>

          <td id="alignText" ng-bind="f.Name"></td>

          <td id="alignText" ng-bind="f.Price"></td>

          <td id="alignText" class="center">

          <a type="button" href="edit_fee.php?id={{f.Id}}">Edit</a>&nbsp;&nbsp;

          <a type="button" style="cursor: pointer" ng-click="deleteFee(f)">Delete</a>

          </td>

        </tr>

      </tbody>

    </table>

  </div>

</div>