// controller for adding menuitem to the database

app.controller('addCategory',['$scope','$http','$location',function($scope,$http,$location){

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  $scope.name = "";
  $scope.cafeteriaId = $location.search().id;
  $scope.addCategory = function () {
    var data = {
      Name: $scope.name,
      CafeteriaId: $scope.cafeteriaId,
      Image: $scope.uploadme.src.split(',')[1]
    };
    if ($scope.name != "" && $scope.cafeteriaId != "") {
      $http.post('/CafeteriaApp.Backend/Requests/Category.php',data)
      .then(function(response){
        window.history.back();
      });
    }
  };
}]);