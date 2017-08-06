// controller for adding menuitem to the database

app.controller('addMenuItem',['$scope','$http','$location',function($scope,$http,$location){

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  $scope.name = "";
  $scope.price = "";
  $scope.description = "";
  $scope.categoryId = $location.search().id;
  $scope.addMenuItem = function () {
    var data = {
      Name: $scope.name,
      Price: $scope.price,
      Description: $scope.description,
      CategoryId: $scope.categoryId,
      Image: $scope.uploadme.src.split(',')[1]
    };
    //if ($scope.name != "" && $scope.categoryId != undefined && $scope.price != "" && $scope.description != "") {
      $http.post('/CafeteriaApp.Backend/Requests/MenuItem.php',data)
      .then(function(response){
        window.history.back();
      });
    //}
  }
}]);