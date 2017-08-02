var app = angular.module('myapp', []);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

// controller for getting menuitems of a category from database

app.controller('getMenuItems', function ($scope,$http,$location) {
$http.get('/CafeteriaApp.Backend/Requests/Customer.php')
.then(function(response){
  console.log(response);
});

  $scope.categoryId = $location.search().id;

  $scope.getMenuItems = function(){
   $http.get('/CafeteriaApp.Backend/Requests/MenuItem.php?categoryId='+$scope.categoryId)
   .then(function (response) {
       $scope.menuItems = response.data;
   });
  }

  $scope.getMenuItems();

});

// controller for order

app.controller('order',function ($scope,$http,$location){
  //$http.get('')
});
