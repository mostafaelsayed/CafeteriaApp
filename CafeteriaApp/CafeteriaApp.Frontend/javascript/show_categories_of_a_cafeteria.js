
// controller for getting categories of a cafeteria from database
layoutApp.controller('getCategories',['$scope','$http','$location',function ($scope,$http,$location) {

  $scope.cafeteriaId = $location.search().id;

  $scope.getCategories = function() {

   $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Category.php?cafeteriaId='+$scope.cafeteriaId)
   .then(function(response) {
       $scope.categories = response.data;
   });

  };

  $scope.getCategories();

}]);
