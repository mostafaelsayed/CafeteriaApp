

app.controller('shipping',['$scope','$http',function($scope,$http) {
	$http.put('/CafeteriaApp.Backend/Requests/fees.php?id='+2)
	.then(function(response) {
		$scope.shippingFee = response.data;
	});
}]);