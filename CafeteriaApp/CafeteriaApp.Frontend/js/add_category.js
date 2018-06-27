var add_categoryApp = angular.module('add_category', ['image']);

add_categoryApp.controller('addCategory', ['$scope', '$http', function($scope, $http) {
  $scope.name = "";

  $scope.csrf_token = document.getElementById('csrf_token').value;

  $scope.addCategory = function() {
    if ($scope.myform.$valid) {
      var data = {
        Name: $scope.name,
        Image: $('#image').attr('src'),
        csrf_token: $scope.csrf_token
      };

      $http.post('/myapi/Category', data)
      .then(function(response) {
        window.history.back();
      });
    }
  };
}]);