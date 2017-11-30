
// controller to deal with favorite items
layoutApp.controller('favorites',['$scope','$http','$rootScope','$timeout',function($scope,$http,
$rootScope,$timeout) {

	$scope.getFavoriteItems = function () {
	
	$http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/FavoriteItem.php')
	.then(function(response) {
      $scope.favoriteItems = response.data;
    });

	};

	$scope.deleteFavorItem = function(menuItemId,index) {
	
  	$http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/FavoriteItem.php?MenuItemId='+menuItemId)
  	.then(function(response) {
      $scope.favoriteItems.splice( index ,1) ;
      $scope.togglePopup('Favorite Item successfully removed !');
    });

	};

	$scope.addToOrder = function(menuItemId) {

    var x = $scope.orderItems.filter(o => o.MenuItemId == menuItemId);

    if(x.length > 0) {
      $scope.increaseQuantity(x[0]); // we extract the first element because x is array (x must be one length array)
    }

    else {
      var data = {
        OrderId: $scope.orderId,
        MenuItemId:menuItemId,
        Quantity: parseInt(1)
      };

      $http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
        $scope.orderId = response.data;
        $scope.togglePopup('Favorite Item added successfully to the order removed !');
      });

    }

  };

  $scope.increaseQuantity = function(orderItem) {

    if($scope.orderId != null) {

      var data = {
        Id: orderItem.Id,
        Quantity: parseInt(orderItem.Quantity)+1,
        Flag: true
      };

      $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
      });

    }

  };

  $rootScope.orderItems = function() {
  };

  $scope.togglePopup = function(message) {

    var popup = document.getElementById("myPopup");
    popup.innerHTML  = message;
    popup.classList.toggle("show");
    $timeout(function() {
      popup.classList.toggle("show");
    }, 2000);

  }

  $scope.getFavoriteItems();

}]);