var app = angular.module('myapp', []);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

app.controller('addCategory',function($scope,$http,$location){
  $scope.name = "";
  $scope.cafeteriaId = $location.search().id;
  $scope.addCategory = function () {
    var data = {
      Name: $scope.name,
      CafeteriaId: $scope.cafeteriaId,
      //action: "addCategory"
    };
    if ($scope.name != "" && $scope.cafeteriaId != "") {
      $http.post('/CafeteriaApp.Backend/Requests/Category.php',data)
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