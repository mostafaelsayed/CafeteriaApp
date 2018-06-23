<?php
  require(__DIR__ . '/../layout.php');
  require(__DIR__ . '/../modal_includes.php');
  validatePageAccess([1]);
?>

<head>

  <title>Managing Category</title>

  <link href="/css/input_file.css" rel="stylesheet">

</head>

<div class="row">

  <h1 class="page-header">Edit Category</h1>

</div>

<div ng-app="edit_category_and_show_and_delete_its_menuitems">

  <div ng-controller="editCategory">

    <form novalidate role="form" name="myform" id="centerBlock">

      <div class="form-group">

        <label>Name</label>

        <input id="inputField" type="text" class="form-control" ng-model="name" ng-maxlength="20" name="name" required />

        <span ng-show="myform.name.$touched && myform.name.$invalid && name.length == 0" id="inputControl" ng-cloak>

          Category Name is Required

          <br>

        </span>

        <span ng-show="myform.name.$error.maxlength" id="inputControl" ng-cloak>

          Category Name must be less than or equal to 20 characters

          <br>

        </span>

        <br>

        <div><label>Image</label></div>

        <input type="file" name="image" id="file" class="inputfile" onchange="readURL(this);">

        <div ng-if="imageUrl != ''">

          <img id="image" ng-src="{{ imageUrl }}" style="width: 300px;height: 300px" />

          <span>

            <button class="btn btn-primary" onclick="event.preventDefault();mylabel.click()" style="position: absolute;margin-top: 150px" id="mybutton">Choose image</button>

            <label id="mylabel" for="file"></label>

          </span>

        </div>

      </div>

      <div class="form-group">

        <input type="submit" value="save" class="btn btn-primary" ng-click="editCategory()">

      </div>

    </form>

  </div>

  <div class="row">

    <h1 class="page-header">MenuItems</h1>

  </div>

  <div class="row" ng-controller="showAndDeleteMenuItems">

    <h3>Manage Your MenuItems</h3>

    <div>

      <a id="add" title="Add MenuItem" id="creatNewCategory" href="menuitem/add" target="_self" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>

    </div>

    <table width="50%" class="table table-bordered">

      <thead>

        <tr>

          <th id="alignText">Name</th>

          <th id="alignText">Price</th>

          <th id="alignText">Description</th>

          <th id="alignText">Actions</th>

        </tr>

      </thead>

      <tbody ng-repeat="m in menuItems">

        <tr class="odd gradeX">

          <td id="alignText" ng-bind="m.Name"></td>

          <td id="alignText" ng-bind="m.Price"></td>

          <td id="alignText" ng-bind="m.Description"></td>

          <td id="alignText" class="center">

            <a id="myButton" href="menuitem/{{m.Id}}/edit" target="_self">Edit</a>&nbsp;

            <a style="cursor: pointer" ng-click="deleteMenuItem(m)">Delete</a>

          </td>

        </tr>

      </tbody>

      <tbody>

        <tr ng-show="menuItems.length == 0">

          <td colspan="5" style="text-align: center"> There are no MenuItems in this Category.</td>

        </tr>

      </tbody>

    </table>

  </div>

</div>

<!-- image module -->
<script src="/js/image_module.js"></script>
<script src="/js/edit_category_and_show_and_delete_its_menuitems.js"></script>

<script type="text/javascript">
  function readURL(input) {
    var file = input.files[0];

    if (input.files && file) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#image').attr('src', e.target.result);
      };

      reader.readAsDataURL(file);
    }
  }
</script>