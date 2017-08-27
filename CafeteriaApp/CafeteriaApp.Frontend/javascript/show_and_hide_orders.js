app.controller('showAndHideOrders',['$scope','$http',function($scope,$http) {

	$http.get('/CafeteriaApp.Backend/Requests/Order.php?flag=1')
	.then(function(response) {
		$scope.orders = response.data;
	});

	$scope.editOrder = function(order) {
		document.location = "/CafeteriaApp.Frontend/Areas/Cashier/Order/Views/edit_order.php?id={order.Id}";
	}
}]);