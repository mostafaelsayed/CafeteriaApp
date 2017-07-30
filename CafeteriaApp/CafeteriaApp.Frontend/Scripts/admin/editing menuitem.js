var app = angular.module('myapp', []);

app.controller('editMenuItem',function($scope,$http,$location){
  $scope.name = "";
  $scope.price = "";
  $scope.description
  $scope.menuItemId = $location.search().id;

  $scope.editMenuItem = function() {
    var data = {
      Name: $scope.name,
      Price: $scope.price,
      Description: $scope.description,
      Id: $scope.menuItemId
    };
    if ($scope.name != "") {
      $http.put('/CafeteriaApp.Backend/Controllers/MenuItem.php',data)
      .then(function(response){
        console.log(response);
        window.history.back();
    // document.location = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/index.php";
      });
    };
  };
});
