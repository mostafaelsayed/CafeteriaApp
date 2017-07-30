
var app = angular.module('myapp', []);
app.controller('addCafeteria',function($scope,$http,$location){
  $scope.Name = "";
  $scope.addCafeteria = function () {
    var data = {
      Name: $scope.name,
      action: "addcafeteria"
    };
    if ($scope.name != "") {
      $http.post('/CafeteriaApp.Backend/Controllers/Cafeteria.php',data)
      .then(function(response){
        //First function handles success
        console.log(response);
        window.history.back();
      }, function(response) {
        //Second function handles error
      });
    }
  };
});
