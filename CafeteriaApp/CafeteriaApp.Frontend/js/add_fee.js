var add_feeApp = angular.module('add_fee',['price']);

// controller for adding fee
add_feeApp.controller('addFee',['$scope','$http',function($scope,$http) {

  $scope.name = "";
  $scope.price = "";

  $scope.addFee = function () {

    if ($scope.myform.$valid) {

      var data = {
        Name: $scope.name,
        Price: $scope.price
      };

      $http.post('../../CafeteriaApp.Backend/Requests/Fee.php',data)
      .then(function(response) {
      	console.log(response);
        document.location = "../../CafeteriaApp.Frontend/Areas/Admin/AppSettings/Views/show_and_delete_fees.php";
      });

    }

  };

}]);

