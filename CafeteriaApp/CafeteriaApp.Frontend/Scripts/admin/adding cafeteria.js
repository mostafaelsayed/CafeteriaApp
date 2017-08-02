var app = angular.module('myapp', []);

// controller for adding cafeteria to the database

app.controller('addCafeteria',function($scope,$http){
  $scope.Name = "";

  $scope.addCafeteria = function () {
    var data = {
      Name: $scope.name,
    };
    if ($scope.name != "") {
      $http.post('/CafeteriaApp.Backend/Requests/Cafeteria.php',data)
      .then(function(response){
        console.log(response);
      });
    }
  };
});
