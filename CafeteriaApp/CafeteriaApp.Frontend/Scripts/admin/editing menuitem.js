var app = angular.module('myapp', []);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

// controller for editing a menuitem

app.controller('editMenuItem',function($scope,$http,$location){
  $scope.menuItemId = $location.search().id;
  $scope.getMenuItem = function(){
    $http.get('/CafeteriaApp.Backend/Requests/MenuItem.php?id='+$scope.menuItemId)
    .then(function(response){
      console.log(response);
      $scope.name = response.data.Name;
      $scope.price = response.data.Price;
      $scope.description = response.data.Description;
    })
  }

  $scope.getMenuItem();

  $scope.editMenuItem = function() {
    var data = {
      Name: $scope.name,
      Price: $scope.price,
      Description: $scope.description,
      Id: $scope.menuItemId
    };
    if ($scope.name != "") {
      $http.put('/CafeteriaApp.Backend/Requests/MenuItem.php',data)
      .then(function(response){
        console.log(response);
        window.history.back();
    // document.location = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/index.php";
      });
    };
  };
});
