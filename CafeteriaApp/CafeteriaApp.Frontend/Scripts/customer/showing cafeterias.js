var app = angular.module('myapp', []);

// controller for getting cafeterias from database
app.controller('getCafeterias', function ($scope,$http) {
  $scope.getCafeterias = function() {
    $http.get('/CafeteriaApp.Backend/Requests/Cafeteria.php')
    .then(function (response) {
      console.log(response);
      $scope.cafeterias = response.data;
    });
  };

  $scope.getCafeterias();

});
