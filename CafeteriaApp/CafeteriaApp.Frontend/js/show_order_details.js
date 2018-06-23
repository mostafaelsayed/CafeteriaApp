var orderDetails = angular.module('order_details', ['customer_and_cashier_order']);

orderDetails.controller('order_details', ['$scope', '$http', function($scope, $http) {
	$scope.orderId = $.urlParam(1);

	$http.get('/myapi/Order/orderId/' + $scope.orderId)
	.then(function(response) {
		$scope.orderDetails = response.data;
	})

	$http.get('/myapi/OrderItem/orderId/' + $scope.orderId)
	.then(function(response) {
		$scope.orderItems = response.data;
	})

	$http.get('/myapi/OrderLocation/orderId/' + $scope.orderId)
	.then(function(response) {
		$scope.myPos = {
    		lat: parseFloat(response.data.Lat),
   			lng: parseFloat(response.data.Lng)
  		};

  		$scope.map = new google.maps.Map(document.getElementById('map'), {
	    	zoom: 10
	  	});

	  	$scope.myMarker = new google.maps.Marker({ // add marker on your current location on the map
          map: $scope.map,
          position: $scope.myPos
        });

	  	$scope.infoWindow = new google.maps.InfoWindow();

	  	$scope.infoWindow.setPosition($scope.myPos);
		$scope.map.setCenter($scope.myPos); // center of map is the current location
		$scope.infoWindow.setContent('Order Location'); // text is 'Order Location'
		$scope.infoWindow.open($scope.map, $scope.myMarker); // position the info window and place a marker
	})
}]);