angular.module('cashierApp', []).controller('showAndHideOrders', ['$scope', '$http', function($scope, $http) {
	$http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php?flag=1')
	.then(function(response) {
		$scope.orders = response.data;
	});
}]);