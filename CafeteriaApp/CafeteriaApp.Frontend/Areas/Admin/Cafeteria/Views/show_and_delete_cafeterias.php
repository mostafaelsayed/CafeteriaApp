<?php

  require_once('CafeteriaApp.Backend/functions.php');

  validatePageAccess($conn);

  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<head>

  <title>Cafeterias</title>

  <!-- order of include not matter in case of dependencies exist -->

  <script src="/CafeteriaApp.Frontend/javascript/show_and_delete_cafeterias.js"></script>

  <?php require_once('CafeteriaApp.Frontend/Areas/Admin/modal_includes.php'); ?>

</head>

<div class="row">

  <div class="col-lg-12">

    <h1 class="page-header">Cafeterias</h1>

  </div>

</div>

<div class="row" ng-app="show_and_delete_cafeterias">

  <div ng-controller="showAndDeleteCafeterias">

    <script type="text/ng-template" id="modal.html">

      <div class="modal fade" id="mymodal">

        <div class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

              <h4 class="modal-title">Are You Sure You Want To Delete This Cafeteria?</h4>

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

    <div class="col-lg-12">

      <div style="margin: auto">

        <div><h3>Manage Your Cafeterias</h3>

          <div>

            <a id="add" title="Add Cafeteria" id="creatNewCafeteria" href="/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/add_cafeteria.php" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>

          </div>

        </div>

        <div>

          <table width="50%" class="table" style="border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
            <thead>

              <tr>

                <th id="alignText">Name</th>

                <th id="alignText">Actions</th>

              </tr>

            </thead>

            <tbody ng-repeat="c in cafeterias">

              <tr>

                <td id="alignText" ng-bind="c.Name"></td>

                <td id="alignText" class="center">

                  <a type="button" href="/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/edit_cafeteria_and_show_and_delete_its_categories.php?id={{c.Id}}">Edit</a>&nbsp;&nbsp;

                  <a type="button" style="cursor: pointer" ng-click="deleteCafeteria(c)">Delete</a>

                </td>

              </tr>

            </tbody>

          </table>

        </div>

      </div>

    </div>

  </div>

</div>