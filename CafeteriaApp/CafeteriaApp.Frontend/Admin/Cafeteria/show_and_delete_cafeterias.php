<?php

  require(__DIR__.'/../../../CafeteriaApp.Backend/functions.php');

  //validatePageAccess($conn);

  require(__DIR__.'/../layout.php');

  require(__DIR__.'/../modal_includes.php');

?>

<head>

  <title>Cafeterias</title>

  <!-- order of include not matter in case of dependencies exist -->

  <script src="../../js/show_and_delete_cafeterias.js"></script>

</head>

<div class="row">

  <div class="col-lg-12">

    <h1 class="page-header">Cafeterias</h1>

  </div>

</div>

<div class="row" ng-app="show_and_delete_cafeterias">

  <div ng-controller="showAndDeleteCafeterias">

    <div class="col-lg-12">

      <div style="margin: auto">

        <div><h3>Manage Your Cafeterias</h3>

          <div>

            <a id="add" title="Add Cafeteria" id="creatNewCafeteria" href="add_cafeteria.php" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>

          </div>

        </div>

        <div>

          <table width="50%" class="table" style="border-collapse: collapse" border="0" cellspacing="0" cellpadding="0">
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

                  <a type="button" href="edit_cafeteria_and_show_and_delete_its_categories.php?id={{c.Id}}">Edit</a>&nbsp;&nbsp;

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