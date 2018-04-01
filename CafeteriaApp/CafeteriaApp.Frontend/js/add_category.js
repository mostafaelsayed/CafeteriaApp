var add_categoryApp = angular.module('add_category',['location_provider','image']);

add_categoryApp.controller('addCategory',['$scope','$http','$location',function($scope,$http,$location) {

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  $scope.name = "";
  $scope.cafeteriaId = $location.search().id;

  $scope.addCategory = function () {

    if ($scope.myform.$valid) {

      var data = {
        Name: $scope.name,
        CafeteriaId: $scope.cafeteriaId,
        Image: $scope.uploadme.src.split(',')[1]
      };

      $http.post('../../../CafeteriaApp.Backend/Requests/Category.php',data)
      .then(function(response) {
        window.history.back();
      });

    }

  };

}]);