

// controller for getting categories of a cafeteria from database


app.controller('reviewOrderAndChargeCustomer', function ($scope,$http,$location) {

	$scope.orderId = $location.search().orderId;
	$scope.paymentId = $location.search().paymentId;
	$scope.payerId = $location.search().PayerID;
	$scope.categoryId = $location.search().categoryId;
	$scope.deliveryPlace = $location.search().deliveryPlace;
	$scope.deliveryTimeId = $location.search().deliveryTimeId;
	$scope.paymentMethodId = $location.search().paymentMethodId;

	$http.get('/CafeteriaApp.Backend/Requests/Order.php?orderId='+$scope.orderId+'&flag='+1)
	.then(function(response) {

		console.log(response);
		
		$scope.orderDetails = response.data;
	 	$scope.total = response.data[0][3];
	 	console.log($scope.orderDetails);

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
