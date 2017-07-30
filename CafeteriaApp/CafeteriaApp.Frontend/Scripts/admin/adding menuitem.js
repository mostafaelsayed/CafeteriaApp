var app = angular.module('myapp', []);

app.controller('addMenuItem',function($scope,$http,$location){
  $scope.name = "";
  $scope.price = "";
  $scope.description = "";
  $scope.categoryId = $location.search().id;
  $scope.addMenuItem = function () {
    var data = {
      Name: $scope.name,
      Price: $scope.price,
      Description: $scope.description,
      CafeteriaId: $scope.categoryId,
      action: "addMenuItem"
    };
    if ($scope.name != "" && $scope.categoryId != "") {
      $http.post('/CafeteriaApp.Backend/Controllers/MenuItem.php',data)
      .then(function(response){
        //First function handles success
        window.history.back();
        // document.location =  "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/edit.php?id="+$scope.cafeteriaid;
        console.log(response);
      }, function(response) {
        //Second function handles error
      });
    }
  };
});
