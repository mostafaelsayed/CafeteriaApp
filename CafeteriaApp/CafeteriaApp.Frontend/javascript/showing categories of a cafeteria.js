var app = angular.module('myapp', []);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

// controller for getting categories of a cafeteria from database

app.controller('getCategories', function ($scope,$http,$location) {
  $scope.cafeteriaId = $location.search().id;

  $scope.getCategories = function(){
   $http.get('/CafeteriaApp.Backend/Requests/Category.php?cafeteriaId='+$scope.cafeteriaId)
   .then(function (response) {
       $scope.categories = response.data;
       console.log(response);
   });
  }

  $scope.getCategories();

});
