var edit_feeApp = angular.module('edit_fee',['location_provider','price']);

edit_feeApp.controller('editFee',['$scope','$http','$location',function($scope,$http,$location) {

  $scope.feeId = $location.search().id;

  $scope.getFee = function() {

    $http.get('../../CafeteriaApp.Backend/Requests/Fee.php?id='+$scope.feeId)
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

      $http.put('../../CafeteriaApp.Backend/Requests/Fee.php',data)
      .then(function(response) {
        console.log(response);
        window.history.back();
      });

    }

  };

}]);