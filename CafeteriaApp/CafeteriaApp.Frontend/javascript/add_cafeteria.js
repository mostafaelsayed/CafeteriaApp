var add_cafeteriaApp = angular.module('add_cafeteria',['image']);

// controller for adding cafeteria
add_cafeteriaApp.controller('addCafeteria',['$scope','$http',function($scope,$http) {

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';
  $scope.name = "";

  $scope.addCafeteria = function () {

    var data = {
      Name: $scope.name,
      Image: $scope.uploadme.src.split(',')[1]
    };

    if ($scope.name != "") {
      
      $http.post('/CafeteriaApp.Backend/Requests/Cafeteria.php',data)
      .then(function(response) {
        window.history.back();
      });

    };

  };

}]);

