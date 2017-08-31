var edit_feeApp = angular.module('edit_fee',['location_provider']);

edit_feeApp.controller('editFee',['$scope','$http','$location',function($scope,$http,$location) {

  $scope.feeId = $location.search().id;

  $scope.getFee = function() {

    $http.get('/CafeteriaApp.Backend/Requests/Fee.php?id='+$scope.feeId)
    .then(function(response) {

      $scope.name = response.data.Name;
      $scope.price = response.data.Price;

    });

  };

  $scope.getFee();

  $scope.editFee = function() {

    var data = {
      Name: $scope.name,
      Price: $scope.price,
      Id: $scope.feeId
    };

    if ($scope.name != null && $scope.price != null && $scope.feeId != null) {

      $http.put('/CafeteriaApp.Backend/Requests/Fee.php',data)
      .then(function(response) {

        console.log(response);
        window.history.back();

      });

    };

  };

}]);