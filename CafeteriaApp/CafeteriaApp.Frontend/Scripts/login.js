var app = angular.module('app',[]);

app.controller('login',['$http',function($http){
  $http.get('/CafeteriaApp.Frontend/Views/login.php')
  .then(function(response){
    console.log(response);
  });
}]);
