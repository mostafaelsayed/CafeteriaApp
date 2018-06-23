var add_feeApp = angular.module('add_fee', ['price']);
// controller for adding fee
add_feeApp.controller('addFee', ['$scope', '$http', function($scope, $http) {
  $scope.name = "";
  $scope.price = "";

  $scope.addFee = function() {
    if ($scope.myform.$valid) {
      var data = {
        Name: $scope.name,
        Price: $scope.price
      };

      $http.post('/myapi/Fee', data)
      .then(function(response) {
        document.location = "/AppSettings/fees";
      });
    }
  };
}]);