var add_categoryApp = angular.module('add_category', ['image']);

add_categoryApp.controller('addCategory', ['$scope', '$http', function($scope, $http) {
  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  $scope.name = "";

  $scope.addCategory = function() {
    if ($scope.myform.$valid) {
      var data = {
        Name: $scope.name,
        Image: $('#image').attr('src')
      };

      $http.post('/myapi/Category', data)
      .then(function(response) {
        window.history.back();
      });
    }
  };
}]);