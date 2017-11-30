
// controller for getting cafeterias from database
layoutApp.controller('cafeterias',['$scope','$http',function($scope,$http) {

  $scope.getCafeterias = function() {

    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Cafeteria.php')
    .then(function (response) {
      $scope.cafeterias = response.data;
    });

  };

  $scope.getCafeterias();

}]);
