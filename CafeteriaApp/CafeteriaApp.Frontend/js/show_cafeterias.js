
// controller for getting cafeterias from database
layoutApp.controller('cafeterias', ['$scope', '$http', function($scope, $http) {
  $scope.getCafeterias = function() {
    $http.get('../../CafeteriaApp.Backend/Requests/Cafeteria.php')
    .then(function(response) {
      $scope.cafeterias = response.data;
    });
  };

  $scope.getCafeterias();

  var ref = document.referrer.substr(0, document.referrer.indexOf('?') );

  if (localStorage.getItem("submit") == 1 && ref == "http://127.0.0.1/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Customer/checkout.php") {
  	localStorage.setItem("submit", 0);
  	alertify.success("Order Submitted");
  }
}]);