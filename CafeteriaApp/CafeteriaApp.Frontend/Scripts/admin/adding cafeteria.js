
var app = angular.module('myapp', []);
app.controller('addCafeteria',function($scope,$http,$location){
  $scope.Name = "";
  $scope.addCafeteria = function () {
    var data = {
      Name: $scope.name,
      //action: "addCafeteria"
    };
    if ($scope.name != "") {
      $http.post('/CafeteriaApp.Backend/Requests/Cafeteria.php',data)
      .then(function(response){
        //First function handles success
        // console.log(response);
        window.history.back();
      }, function(response) {
        //Second function handles error
      });
    }
  };
});
