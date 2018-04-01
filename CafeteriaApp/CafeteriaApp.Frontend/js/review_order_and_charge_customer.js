
// controller for reviewing customer order
layoutApp.controller('reviewOrderAndChargeCustomer', ['$scope', '$http', '$location', function ($scope, $http, $location) {

	$scope.orderType = $location.search().orderType;
	$scope.paymentId = $location.search().paymentId;
	$scope.payerId = $location.search().PayerID;
	$scope.paymentMethodId = $location.search().paymentMethodId;

	$http.get('../../CafeteriaApp.Backend/Requests/Order.php?orderId=' + $scope.orderId + '&flag=' + 1)
	.then(function(response) {
		$scope.orderDetails = response.data;
	 	$scope.total = response.data[0][4];
	} );

} ] );