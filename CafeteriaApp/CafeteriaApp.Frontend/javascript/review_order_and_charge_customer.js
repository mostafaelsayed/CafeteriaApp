

// controller for getting categories of a cafeteria from database


app.controller('OrderCheckout2', function ($scope,$http,$location) {

	$scope.orderId = $location.search().orderId;
	$scope.paymentId = $location.search().paymentId;
	$scope.payerId = $location.search().PayerID;

	$http.get('/CafeteriaApp.Backend/Requests/Order.php?orderId='+$scope.orderId+'&flag='+1)
	.then(function(response) {

		console.log(response);
		
		$scope.orderItemsDetails = response.data;
	 	$scope.total = response.data[0][5];
	 	$scope.deliveryPlace = response.data[0][4];

	});

	$scope.chargeCustomer = function() {

	 	var data = {
	 		paymentId: $scope.paymentId,
	 		payerId: $scope.payerId
	 	};

	 	$http.put('/CafeteriaApp.Backend/Requests/Order.php',data)
	 	.then(function(response) {

	 		console.log(response);

	 		if (response.data == "1") {
	 			document.location = "/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php?orderId="+$scope.orderId;
	 		}

	 	});

	}

});
