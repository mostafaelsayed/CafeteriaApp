
// controller for reviewing customer order
app.controller('reviewOrderAndChargeCustomer',['$scope','$http','$location',function ($scope,$http,$location) {

	$scope.orderId = $location.search().orderId;
	$scope.paymentId = $location.search().paymentId;
	$scope.payerId = $location.search().PayerID;
	$scope.categoryId = $location.search().categoryId;
	$scope.deliveryPlace = $location.search().deliveryPlace;
	$scope.deliveryTimeId = $location.search().deliveryTimeId;
	$scope.paymentMethodId = $location.search().paymentMethodId;

	$http.get('/CafeteriaApp.Backend/Requests/Order.php?orderId='+$scope.orderId+'&flag='+1)
	.then(function(response) {
		$scope.orderDetails = response.data;
	 	$scope.total = response.data[0][4];
	});

}]);
