<?php
	require(__DIR__.'/../../CafeteriaApp.Backend/functions.php');
	validatePageAccess([1,2]);
	require(__DIR__.'/../layout.php');
?>

<head>
	<title>Menus</title>
</head>

<div class="container">

  <h1 class="page-header" id="header">Menus</h1>

  <div ng-controller="getCategories">

    	<div class="col-md-6" ng-repeat="c in categories">

        <div style="text-align: center;font-size: 20px">

      		<a href="menuitems.php?categoryId={{c.Id}}&categoryName={{c.Name}}" style="color: orange">
            <img style="display: block;margin: auto;width: 300px;height: 300px" ng-src={{c.Image}} />
      			<span ng-bind="c.Name"></span>

      		</a>

       		<br>

        </div>

    	</div>

  </div>

</div>

<?php require(__DIR__.'/footer.php'); ?>

<script src="../js/show_categories_of_a_cafeteria.js"></script>
