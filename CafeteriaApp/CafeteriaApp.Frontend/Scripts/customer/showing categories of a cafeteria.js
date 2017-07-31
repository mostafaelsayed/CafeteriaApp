var app = angular.module('myapp', []);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

// controller for getting categories from database

app.controller('getByCafeteriaId', function ($scope,$http,$location) {
  $scope.cafeteriaid = $location.search().id;

  $scope.getcategories = function(){
   $http.get('/CafeteriaApp.Backend/Requests/Category.php?cafeteriaId='+$scope.cafeteriaid)
   .then(function (response) {
       $scope.categories = response.data;
       console.log(response);
   });
  }

  $scope.getcategories();

});
