app.controller('editCashier',['$scope','$http','userService','$location',function($scope,$http,userService,$location) {
  $scope.roles = ["Customer","Admin","Cashier"];
  $scope.selectedRole = "Cashier";
}]);