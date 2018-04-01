var add_cafeteriaApp = angular.module('add_cafeteria',['image']);

// controller for adding cafeteria
add_cafeteriaApp.controller('addCafeteria',['$scope','$http',function($scope,$http) {

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';
  $scope.name = "";

  $scope.addCafeteria = function () {

    if ($scope.myform.$valid) {

      var data = {
        Name: $scope.name,
        Image: $scope.uploadme.src.split(',')[1]
      };
        
      $http.post('../../../CafeteriaApp.Backend/Requests/Cafeteria.php',data)
      .then(function(response) {
        document.location = "../../../CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show_and_delete_cafeterias.php";
      });

    }

  };

}]);

