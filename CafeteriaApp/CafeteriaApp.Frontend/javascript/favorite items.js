app.controller('favorites' , function($scope,$http) {

	$scope.getFavoriteItems=function () {
	
	$http.get('/CafeteriaApp.Backend/Requests/FavoriteItem.php')
	.then(function (response) {
      //console.log(response);
      $scope.favoriteItems = response.data;
    });

	}


	

	$scope.deleteFavorItem=function (menuItemId,index) {
	
	$http.delete('/CafeteriaApp.Backend/Requests/FavoriteItem.php?MenuItemId='+menuItemId)
	.then(function (response) {
      //console.log(response);
      $scope.favoriteItems.splice( index ,1) ;
    });

	}


  $scope.getOrder = function() {
    $http.get('/CafeteriaApp.Backend/Requests/Order.php')
    .then(function(response) {
      
      $scope.currentOrder = response.data;
      $scope.orderId = $scope.currentOrder.Id;
    
      if ($scope.orderId == undefined) {
        $scope.orderId = null;
        $scope.orderItems = [];
     
        $scope.TotalPrice = 0;
      }
    
      else if($scope.orderId != undefined) {
        $scope.getOrderItems();
      }
     
    });
  }


  
  $scope.getOrderItems = function() {
    $http.get('/CafeteriaApp.Backend/Requests/OrderItem.php?orderId='+$scope.orderId)
    .then(function(response) {
      //console.log(response);
      $scope.orderItems = response.data;
      ////console.log(response.data);
      //$scope.TotalPrice = $scope.getTotalPrice();
    });
  }


	 $scope.addToOrder = function(menuItemId) {
    ////console.log(1);
    var x = $scope.orderItems.filter(o => o.MenuItemId == menuItemId);
    if(x.length > 0) {
      $scope.increaseQuantity(x[0]); // we extract the first element because x is array (x must be one length array)
    }
    else {
      var data = {
        OrderId: $scope.orderId,
        MenuItemId:menuItemId,
        Quantity: parseInt(1)
        //CustomerId: $scope.customerId
      };
      ////console.log($scope.orderId);
      $http.post('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
        //console.log(response);
        $scope.orderId = response.data;
        $scope.getOrderItems();
      });
    }
  }

$scope.increaseQuantity = function(orderItem) {
    if($scope.orderId != null) {
      var data = {
        Id: orderItem.Id,
        Quantity: parseInt(orderItem.Quantity)+1,
        Flag: true
      };
      $http.put('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
        ////console.log(response);
        $scope.getOrderItems();
      });
    }
  }



$scope.getFavoriteItems();

  $scope.getOrder();

});

