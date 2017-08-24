

// controller for getting categories of a cafeteria from database


app.controller('reviewOrderAndChargeCustomer', function ($scope,$http,$location) {

	$scope.orderId = $location.search().orderId;
	$scope.paymentId = $location.search().paymentId;
	$scope.payerId = $location.search().PayerID;
	$scope.categoryId = $location.search().categoryId;

	$http.get('/CafeteriaApp.Backend/Requests/Order.php?orderId='+$scope.orderId+'&flag='+1)
	.then(function(response) {

		console.log(response);
		
		$scope.orderItemsDetails = response.data;
	 	$scope.total = response.data[0][7];
	 	$scope.deliveryPlace = response.data[0][6];
	 	$scope.deliveryTimeId = response.data[0][5];
	 	$scope.paymentMethodId = response.data[0][4];

	});

	// $scope.chargeCustomer = function() {

	//  	var data = {
	//  		paymentId: $scope.paymentId,
	//  		payerId: $scope.payerId,
	//  		categoryId: $location.search().categoryId
	//  	};

	//  	$http.put('/CafeteriaApp.Backend/Requests/Order.php',data)
	//  	.then(function(response) {

	//  		console.log(response);
	//  		document.location = response.data;

	//  	});

	// }

});
