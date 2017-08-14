app.controller('Cafeterias', function ($scope,$http) {

  $scope.getCafeterias = function() {
    $http.get('/CafeteriaApp.Backend/Requests/Cafeteria.php')
   
    .then(function (response) {
      console.log(response);
      $scope.cafeterias = response.data;
    }, function(response) {
        //Second function handles error
        //console.log( "Something went wrong");
    }
    );
  }

  $scope.getCafeterias();



});
