<?php

	require('CafeteriaApp.Backend/functions.php');

  validatePageAccess($conn);

	require('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<head>

	<title>Fees</title>

  <?php require('CafeteriaApp.Frontend/Areas/Admin/modal_includes.php'); ?>

	<script src="/CafeteriaApp.Frontend/javascript/show_and_delete_fees.js"></script>

</head>

<div class="row">

  <h1 class="page-header">Fees</h1>

</div>

<div class="row" ng-app="show_and_delete_fees" ng-controller="showAndDeleteFees">

	<script type="text/ng-template" id="modal.html">

    <div class="modal fade" id="mymodal">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h4 class="modal-title">Are You Sure You Want To Delete This Fee?</h4>

          </div>

          <div class="modal-body">

            <p>It's your call...</p>

          </div>

          <div class="modal-footer">

            <button type="button" class="btn btn-default" ng-click="close('No')" data-dismiss="modal">No</button>

            <button type="button" class="btn btn-primary" ng-click="close('Yes')" data-dismiss="modal">Yes</button>

          </div>

        </div>

      </div>

    </div>

  </script>

  <div style="margin: auto">

    <div><h3>Manage Your Fees</h3></div>

    <div>

      <a id="add" title="Add Fee" href="/CafeteriaApp.Frontend/Areas/Admin/AppSettings/Views/add_fee.php" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>

    </div>

  	<table width="50%" class="table" style="border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">

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

          <a type="button" href="/CafeteriaApp.Frontend/Areas/Admin/AppSettings/Views/edit_fee.php?id={{f.Id}}">Edit</a>&nbsp;&nbsp;

          <a type="button" style="cursor: pointer" ng-click="deleteFee(f)">Delete</a>

          </td>

        </tr>

      </tbody>

    </table>

  </div>

</div>