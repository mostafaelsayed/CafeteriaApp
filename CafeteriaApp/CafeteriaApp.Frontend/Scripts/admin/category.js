var app = angular.module('myapp', []);
    app.config(['$locationProvider', function($locationProvider) {
      $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
      });
    }]);
// controller for getting cafeterias from database
app.controller('getByCafeteriaId', function ($scope,$http,$location) {
  var id = $location.search().id;
    $http.get('/CafeteriaApp.Backend/Controllers/Category.php?Id='+id)
    .then(function (response) {
        $scope.categories = response.data;
        console.log(response);
    });
});
// controller for adding cafeteria in the database
app.controller('addCategory',function($scope,$http){
  $scope.Name = "";
  $scope.cafeteriaId = "";
  $scope.addCategory = function () {
    var data = {
      Name: $scope.Name,
      CafeteriaId: $scope.cafeteriaId,
      action: "addCafeteria"
    };
  if ($scope.Name != "" && $scope.cafeteriaId != "") {
    $http.post('/CafeteriaApp.Backend/Controllers/Category.php',data)
    .then(function(response){
      //First function handles success
      //console.log(response);
      //document.location="/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show.php";
    }, function(response) {
        //Second function handles error
        //console.log(response);
    });
  }
  };
});
