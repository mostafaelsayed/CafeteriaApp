<?php

  require(__DIR__ . '/../CafeteriaApp.Backend/functions.php');

  // validatePageAccess($conn);

  require(__DIR__ . '/Customer/layout.php');
   
?>

<head>
  <title>Our Branches</title>
</head>

<style type="text/css">
  th, tr, td{
    text-align:center;
    color: white;
  }
</style>

<div class="container" ng-controller="branch" style="text-align: center;position: relative">

  <div>

    <h2 style="color: orange">Our Branches</h2>

  </div>

  <table class="table" style="margin: auto" ng-show="branches.length > 0" ng-cloak>

    <thead>

      <tr>
       <th>Address</th>
        <th>Phone</th>
      </tr>

    </thead>

    <tbody>

      <tr ng-repeat="fi in branches">
        <td ng-bind="fi.Address" id="thead"></td>
        <td ng-bind="fi.Phone" id="thead"></td>
      </tr>

    </tbody>

  </table>

   <h1 ng-show="favoriteItems.length==0" ng-cloak> No info yet ! </h1>

</div>

<?php require_once(__DIR__ . '/Public/footer.php'); ?>

<script type="text/javascript">
// controller to deal with favorite items
layoutApp.controller('branch', ['$scope', '$http', function($scope, $http) {
  $scope.getBranches = function() {
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Branch.php')
    .then(function(response) {
      $scope.branches = response.data;
    });
  };

  $scope.getBranches();
}]);

</script>