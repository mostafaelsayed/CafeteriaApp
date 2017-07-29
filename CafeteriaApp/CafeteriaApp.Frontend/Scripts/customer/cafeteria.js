var app = angular.module('myapp', []);

// controller for getting cafeterias from database
app.controller('getcafeterias', function ($scope,$http) {
  //$scope.cafeterias = [];
    $scope.getcafeterias = function() {
      $http.get('/CafeteriaApp.Backend/Controllers/Cafeteria.php?action=getCafeterias')
    .then(function (response) {
        $scope.cafeterias = response.data;
    });
  };
  $scope.getcafeterias();
});
