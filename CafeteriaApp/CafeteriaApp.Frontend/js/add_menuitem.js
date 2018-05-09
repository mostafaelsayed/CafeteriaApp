var add_menuitemApp = angular.module('add_menuitem', ['image', 'price']);

add_menuitemApp.controller('addMenuItem', ['$scope', '$http', function($scope, $http) {

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  $scope.name = "";
  $scope.price = "";
  $scope.description = "";
  $scope.categoryId = $.urlParam('id');

  $scope.addMenuItem = function () {

    if ($scope.myform.$valid) {

      var data = {
        Name: $scope.name,
        Price: $scope.price,
        Description: $scope.description,
        CategoryId: $scope.categoryId,
        Image: $scope.uploadme.src.split(',')[1]
      };

      $http.post('../../../CafeteriaApp.Backend/Requests/MenuItem.php', data)
      .then(function(response) {
        window.history.back();
      });
    
    }

  };

}]);