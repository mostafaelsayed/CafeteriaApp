var add_menuitemApp = angular.module('add_menuitem', ['image', 'price']);

add_menuitemApp.controller('addMenuItem', ['$scope', '$http', function($scope, $http) {
  $scope.name = "";
  $scope.price = "";
  $scope.description = "";
  $scope.categoryId = $.urlParam(2);

  $scope.addMenuItem = function() {
    if ($scope.myform.$valid) {
      var data = {
        Name: $scope.name,
        Price: $scope.price,
        Description: $scope.description,
        CategoryId: $scope.categoryId,
        Image: $('#image').attr('src')
      };

      $http.post('/myapi/MenuItem', data)
      .then(function(response) {
        //console.log(response);
        window.history.back();
      });
    }
  };
}]);