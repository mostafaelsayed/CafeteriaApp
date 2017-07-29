var app = angular.module('myapp', []);
app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);
// controller for getting categories from database
app.controller('getMenuItems', function ($scope,$http,$location) {
  $scope.categoryid = $location.search().id;
  // console.log($scope.cafeteriaid);
  $scope.getMenuItems = function(){
   $http.get('/CafeteriaApp.Backend/Controllers/MenuItem.php?Id='+$scope.categoryid)
   .then(function (response) {
       $scope.menuItems = response.data;
       console.log(response);
   });
  }
   $scope.getMenuItems();

});
