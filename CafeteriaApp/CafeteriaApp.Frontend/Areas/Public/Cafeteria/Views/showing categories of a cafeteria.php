<title>Categories</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
?>

<script src="/CafeteriaApp.Frontend/javascript/showing categories of a cafeteria.js"></script>

<h1 class="page-header" id="header">Categories</h1>

<div  ng-controller="getCategories">
  <div ng-repeat="c in categories" style="width:15%;margin:auto">

    <br />
  </div>
</div>

