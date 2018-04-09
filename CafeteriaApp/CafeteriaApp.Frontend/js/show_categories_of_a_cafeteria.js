
// controller for getting categories of a cafeteria from database
layoutApp.controller('getCategories', ['$scope', '$http', function($scope, $http) {
  
  $scope.menuId = $.urlParam('menu_id'); 

  $scope.getCategories = function() {
   $http.get('../../CafeteriaApp.Backend/Requests/Category.php?cafeteriaId=' + $scope.menuId)
   .then(function(response) {
       $scope.categories = response.data;
   });
  };

  $scope.getCategories();
}]);