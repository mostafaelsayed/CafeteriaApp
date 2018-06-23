var edit_feeApp = angular.module('edit_fee', ['price']);

edit_feeApp.controller('editFee', ['$scope', '$http', function($scope, $http) {

  $scope.feeId = $.urlParam(1);

  $scope.getFee = function() {
    $http.get('/myapi/Fee/id/' + $scope.feeId)
    .then(function(response) {
      $scope.name = response.data.Name;
      $scope.price = response.data.Price;
    });
  };

  $scope.getFee();

  $scope.editFee = function() {
    if ($scope.myform.$valid) {
      var data = {
        Name: $scope.name,
        Price: $scope.price,
        Id: $scope.feeId
      };

      $http.put('/myapi/Fee', data)
      .then(function(response) {
        window.history.back();
      });
    }
  };
}]);