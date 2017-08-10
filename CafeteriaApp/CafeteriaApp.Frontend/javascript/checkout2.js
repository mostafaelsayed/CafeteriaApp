var app = angular.module('myapp', []);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

// controller for getting categories of a cafeteria from database


app.controller('OrderCheckout2', function ($scope,$http,$location) {
//  $scope.orderId = $location.search().orderId;
 // $scope.orderno =5;
 $scope.name ="";




});
