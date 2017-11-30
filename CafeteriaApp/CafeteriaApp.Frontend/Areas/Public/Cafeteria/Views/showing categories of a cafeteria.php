<?php

	require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/functions.php');

	//validatePageAccess($conn);

	require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Customer/layout.php');

?>

<head>

	<title>Categories</title>

	<script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/show_categories_of_a_cafeteria.js"></script>

</head>

<div class="container">

  <h1 class="page-header" id="header">Categories</h1>

  <div ng-controller="getCategories">

    	<div ng-repeat="c in categories">

        <div style="text-align:center;font-size:20px">

      		<a href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Customer/Category/Views/showing menuitems of a category and customer order.php?categoryId={{c.Id}}" style="color: blue" target="_self">

      			<span ng-bind="c.Name"></span>

      		</a>

       		<br>

        </div>

    	</div>

  </div>

</div>

<?php require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/footer.php'); ?>