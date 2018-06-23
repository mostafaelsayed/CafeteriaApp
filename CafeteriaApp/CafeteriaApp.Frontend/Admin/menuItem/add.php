<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([1]);
?>

<head>

  <title>Adding MenuItem</title>

  <link href="/css/input_file.css" rel="stylesheet">

</head>

<div class="row">

  <h1 class="page-header">Create MenuItem</h1>

</div>

<div class="row" ng-app="add_menuitem" ng-controller="addMenuItem">

  <div class="row">

    <form novalidate role="form" name="myform" class="css-form" id="centerBlock">

      <div class="form-group">

        <label>Name</label>

        <input id="inputField" type="text" class="form-control" ng-maxlength="30" ng-model="name" name="name" required />

        <span ng-show="myform.name.$touched && myform.name.$invalid && name.length == 0" id="inputControl" ng-cloak>

          MenuItem Name is Required

          <br>

        </span>

        <span ng-show="myform.name.$error.maxlength" id="inputControl" ng-cloak>

          MenuItem Name must be less than or equal to 30 characters

          <br>

        </span>

        <br>

        <div><label>Price</label></div>

        <input id="inputField" type="text" class="form-control" ng-model="price" number-check name="price">

        <span ng-show="myform.price.$touched && myform.price.$error.numberCheck" id="inputControl" ng-cloak>

          Price is invalid.it must be a number of at most 9 digits and optinally followed by at most 2 digit

          <br>

        </span>

        <span ng-show="myform.price.$touched && myform.price.$error.numberEmpty" id="inputControl" ng-cloak>

          Price is Required

          <br>

        </span>

        <br>

        <div><label>Description</label></div>

        <input id="inputField" type="text" class="form-control" ng-model="description" ng-maxlength="50" name="description" required />

        <span ng-show="myform.description.$touched && myform.description.$invalid && description.length == 0" id="inputControl" ng-cloak>

          Description is Required

          <br>

        </span>

        <span ng-show="myform.description.$error.maxlength" id="inputControl" ng-cloak>

          Description must be less than or equal to 50 characters

          <br>

        </span>

        <br>

        <div><label>Image</label></div>

        <input type="file" name="image" id="file" class="inputfile" onchange="readURL(this);">

        <img id="image" style="width: 300px;height: 300px">

        <span>

          <button class="btn btn-primary" onclick="event.preventDefault();mylabel.click()" style="position: absolute;margin-top: 150px">Choose image</button>

          <label id="mylabel" for="file"></label>

        </span>

      </div>

      <div class="form-group">

        <input ng-click="addMenuItem()" value="Save" type="submit" class="btn btn-primary">

      </div>

    </form>

  </div>

</div>


<script src="/js/image_module.js"></script>
<script src="/js/price_module.js"></script>
<script src="/js/add_menuitem.js"></script>

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