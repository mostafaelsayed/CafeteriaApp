var add_feeApp = angular.module('add_fee',[]);

// controller for adding fee
add_feeApp.controller('addFee',['$scope','$http',function($scope,$http) {

  $scope.name = "";
  $scope.price = "";

  $scope.addFee = function () {

    var data = {
      Name: $scope.name,
      Price: $scope.price
    };

    if ($scope.name != "" && $scope.price != "") {

      $http.post('/CafeteriaApp.Backend/Requests/Fee.php',data)
      .then(function(response) {

      	console.log(response);
        window.history.back();

      });

    };

  };

}]);

