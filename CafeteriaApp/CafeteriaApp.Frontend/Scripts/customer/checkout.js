var app = angular.module('myapp', []);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

// controller for getting categories of a cafeteria from database

app.controller('OrderCheckout', function ($scope,$http,$location) {
  $scope.orderId = $location.search().orderId;

  $scope.discardOrder = function(){
   $http.delete('/CafeteriaApp.Backend/Requests/Order.php?orderId='+$scope.orderId)
   .then(function (response) {
       //$scope.categories = response.data;
       //console.log(response);
    document.location =  "/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";

   });
  }

  //$scope.discardOrder();

});
