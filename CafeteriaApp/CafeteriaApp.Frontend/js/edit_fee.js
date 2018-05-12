var edit_feeApp = angular.module('edit_fee', ['price']);

edit_feeApp.controller('editFee', ['$scope', '$http', function($scope, $http) {

  $scope.feeId = $.urlParam('id');

  $scope.getFee = function() {
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Fee.php?id=' + $scope.feeId)
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

      $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Fee.php', data)
      .then(function(response) {
        window.history.back();
      });
    }
  };
}]);