// controller for getting categories of a cafeteria from database
layoutApp.controller('getCategories', ['$scope', '$http', function($scope, $http) {
  $scope.getCategories = function() {
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Category.php')
    .then(function(response) {
      $scope.categories = response.data;
    });
  };

  $scope.getCategories();

  var ref = document.referrer.substr(0, document.referrer.indexOf('?') );

  if (localStorage.getItem("submit") == 1 && (ref == "http://127.0.0.1/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Customer/checkout.php" || document.referrer == 'http://127.0.0.1/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Templates/credit-card-payment.php') ) {
  	localStorage.setItem("submit", 0);
    console.log(2);
  	alertify.success("Order Submitted");
  }
  else if (localStorage.getItem("discard") == 1) {
    localStorage.setItem("discard", 0);
    alertify.success('Order Discarded');
  }
}]);