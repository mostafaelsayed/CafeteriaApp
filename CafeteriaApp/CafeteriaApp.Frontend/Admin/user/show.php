<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([1]);
  require(__DIR__ . '/../modal_includes.php');
?>

<head>
  <title>Users</title>
</head>

<div class="row">

  <h1 class="page-header">Users</h1>

</div>

<div class="row" ng-app="show_and_delete_users">

  <div ng-controller="showAndDeleteUsers">

    <div style="margin: auto">

      <h3>Manage Your Users</h3>

      <div>

        <a id="add" title="Add Users" href="/admin/user/add" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>

      </div>

      <table width="50%" class="table" style="border-collapse: collapse" border="0" cellspacing="0" cellpadding="0">

        <thead>

          <tr>

            <th id="alignText">Email</th>

            <th id="alignText">Actions</th>

          </tr>

        </thead>

        <tbody ng-repeat="u in users">

          <tr>

            <td id="alignText" ng-bind="u.Email"></td>

            <td id="alignText" class="center">

              <a type="button" href="/admin/user/{{u.Id}}/edit">Edit</a>&nbsp;&nbsp;

              <a type="button" style="cursor: pointer" ng-click="deleteUser(u)">Delete</a>

            </td>

          </tr>

        </tbody>

      </table>

    </div>

  </div>

</div>

<script src="/js/show_and_delete_users.js"></script>
