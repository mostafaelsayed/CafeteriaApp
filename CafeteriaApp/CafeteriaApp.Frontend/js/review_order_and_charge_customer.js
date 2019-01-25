
	// controller for reviewing customer order
	layoutApp.controller('reviewOrderAndChargeCustomer', ['$scope', '$http', '$location',
	function ($scope, $http, $location) {
		$scope.paymentId = $.urlStringParam('paymentId');
		$scope.payerId = $.urlStringParam('PayerID');
		//$scope.paymentMethod = $.urlStringParam('paymentMethod');
		$scope.orderId = $.urlStringParam('orderId');
		console.log($scope.orderId);

		$http.get('/myapi/Order/orderId/' + $scope.orderId + '/flag/1')
		.then(function(response) {
			console.log(response);
			$scope.orderDetails = response.data;
			$orderTotalAndFees = $scope.orderDetails[0];
			$scope.orderItems = $scope.orderDetails[1];
		 	$scope.total = $orderTotalAndFees['Total'];
		 	$scope.deliveryFee = $orderTotalAndFees['DeliveryFee'];
		 	$scope.taxFee = $orderTotalAndFees['TaxFee'];
		 	$scope.subTotal = $scope.total - $scope.deliveryFee - $scope.taxFee;
		});
	}]);