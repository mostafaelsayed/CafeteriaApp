var add_categoryApp = angular.module('add_category', ['image']);

add_categoryApp.controller('addCategory', ['$scope', '$http', function($scope, $http) {
  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  $scope.name = "";
  $scope.cafeteriaId = $.urlParam('id');

  $scope.addCategory = function() {
    if ($scope.myform.$valid) {
      var data = {
        Name: $scope.name,
        CafeteriaId: $scope.cafeteriaId,
        Image: $scope.uploadme.src.split(',')[1]
      };

      $http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Category.php', data)
      .then(function(response) {
        window.history.back();
      });
    }
  };
}]);