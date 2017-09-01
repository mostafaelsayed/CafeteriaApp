<?php

  require_once("CafeteriaApp.Backend/functions.php");

  validatePageAccess($conn);

  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<head>

  <link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

  <title>Managing Cafeteria</title>

  <!-- location provider -->
  <script src="/CafeteriaApp.Frontend/javascript/location_provider.js"></script>

  <?php require_once('CafeteriaApp.Frontend/Areas/Admin/modal_includes.php'); ?>

  <!-- image module -->
  <script src="/CafeteriaApp.Frontend/javascript/image_module.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/edit_cafeteria_and_show_and_delete_its_categories.js"></script>

</head>

<div class="row">

  <h1 class="page-header">Edit Cafeteria</h1>

</div>

<div class="row" ng-app="edit_cafeteria_and_show_and_delete_its_categories">

  <div ng-controller="editCafeteria">

    <div class="row">

      <form novalidate role="form" name="myform" id="centerBlock">

        <div class="form-group">

          <label>Name</label>

          <input id="inputField" type="text" class="form-control" ng-model="name" autofocus="autofocus" name="name" required />

          <span ng-show="myform.$submitted && myform.name.$invalid && myform.name.$touched" id="inputControl" ng-cloak>

            Cafeteria Name is Required

            <br>

          </span>

          <br>

          <div><label>Image</label></div>

          <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">

          </div>

          <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">

          <div ng-if="uploadme.src != ''">

            <img ng-src="{{ uploadme.src }}" style="width:300px;height:300px" />

          </div>

          <div ng-if="uploadme.src == ''">

            <img ng-src="{{ imageUrl }}" style="text-align:center;width:300px;height:300px">&nbsp;

            <span>

              <button class="btn btn-primary" onclick="mylabel.click()" style="position:absolute;margin-top:150px" id="mybutton">Choose image</button>

              <label id="mylabel" for="file"></label>

            </span>

            <br>

          </div>

        </div>

        <div class="form-group">

          <input type = "submit" value = "save" class="btn btn-primary" ng-click="editCafeteria()">

        </div>

      </form>

    </div>

  </div>

  <div class="row">

    <h1 class="page-header">Categories</h1>

  </div>

  <div class="row" ng-controller="showAndDeleteCategories">

    <h3>Manage Your categories</h3>

    <div>

      <a id="add" title="Add Category" href="/CafeteriaApp.Frontend/Areas/Admin/Category/Views/add_category.php?id={{cafeteriaId}}" target="_self" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>

    </div>

    <table width="50%" class="table table-bordered">

      <thead>

        <tr>

          <th id="alignText">Name</th>

          <th id="alignText">Actions</th>

        </tr>

      </thead>

      <tbody ng-repeat="c in categories">

        <tr>

          <td id="alignText" ng-bind="c.Name"></td>

          <td id="alignText" class="center">

            <a id="myButton" href="/CafeteriaApp.Frontend/Areas/Admin/Category/Views/edit_category_and_show_and_delete_its_menuitems.php?id={{c.Id}}" target="_self">Edit</a>&nbsp;

            <a style="cursor:pointer" ng-click="deleteCategory(c)">Delete</a>

          </td>

        </tr>

      </tbody>

      <tbody>

        <tr ng-show="categories.length == 0">

          <td colspan="5" style="text-align:center"> There are no Categories in this Cafeteria.</td>

        </tr>

      </tbody>

    </table>

  </div>

</div>