app.controller('showAndHideOrders',['$scope','$http',function($scope,$http) {

	$http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php?flag=1')
	.then(function(response) {
		$scope.orders = response.data;
	});

	$scope.editOrder = function(order) {
		document.location = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Cashier/Order/Views/edit_order.php?id={order.Id}";
	}
}]);