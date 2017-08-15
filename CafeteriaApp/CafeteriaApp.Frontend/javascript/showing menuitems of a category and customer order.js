

// controller for getting menuitems of a category from database

app.controller('getMenuItemsAndCustomerOrder', function ($scope,$http,$location) {

  $scope.categoryId = $location.search().id;


  $scope.getMenuItems = function() {
  
   $http.get('/CafeteriaApp.Backend/Requests/MenuItem.php?categoryId='+$scope.categoryId)
   .then(function(response) {
       $scope.menuItems = response.data;
   });
  }
 


  $scope.getCurrentCustomer = function() {

    $http.get('/CafeteriaApp.Backend/Requests/Customer.php')
    .then(function(response) {
      $scope.customerId = response.data.Id;
      //console.log($scope.customerId);
      if ($scope.customerId == undefined) {
        document.location = "/CafeteriaApp.Frontend/Views/login.php";
      }
      else {
        //console.log($scope.customerId);
        $scope.getOrder();
      }
    });
  }


  $scope.getOrderItems = function() {
    $http.get('/CafeteriaApp.Backend/Requests/OrderItem.php?orderId='+$scope.orderId)
    .then(function(response) {
      //console.log(response.data);
      $scope.orderItems = response.data;
      //console.log(response.data);
      //$scope.TotalPrice = $scope.getTotalPrice();
    });
  }


  $scope.getOrder = function() {
    //console.log($scope.customerId);
    $http.get('/CafeteriaApp.Backend/Requests/Order.php')
    .then(function(response) {
      //console.log(response);
      $scope.currentOrder = response.data;
      $scope.orderId = $scope.currentOrder.Id;
      //console.log($scope.orderId);
      if ($scope.orderId == undefined) {
        $scope.orderId = null;
        $scope.orderItems = [];
        //console.log($scope.orderItems);
        $scope.TotalPrice = 0;
      }
      //console.log($scope.orderId);
      else if($scope.orderId != undefined) {
        $scope.getOrderItems();
      }
     
    });
  }



  

  $scope.addToOrder = function(menuItem) {
    //console.log(1);
    var x = $scope.orderItems.filter(o => o.MenuItemId == menuItem.Id);
    if(x.length > 0) {
      $scope.increaseQuantity(x[0]); // we extract the first element because x is array (x must be one length array)
    }
    else {
      var data = {
        OrderId: $scope.orderId,
        MenuItemId: menuItem.Id,
        Quantity: parseInt(1)
        //CustomerId: $scope.customerId
      };
      //console.log($scope.orderId);
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
        //console.log(response);
        $scope.getOrderItems();
      });
    }
  }


  $scope.decreaseQuantity = function(orderItem) {
    var data = {
      Id: orderItem.Id,
      Quantity: parseInt(orderItem.Quantity)-1,
      Flag: false
    };
    if (orderItem.Quantity > 1) {
      $http.put('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
        $scope.getOrderItems();
      });
    }
    else {
      $scope.deleteOrderItem(orderItem);
    }
  }


  $scope.deleteOrderItem = function(orderItem) {
    $http.delete('/CafeteriaApp.Backend/Requests/OrderItem.php?id='+orderItem.Id)
    .then(function(response) {
      $scope.getOrderItems();
    });
  }


$scope.toggleFavoriteItem = function(menuItemId) {
    var data = {
        menuItemId: menuItemId
      };

   if ( document.getElementById(menuItemId).style.color==="red")
    {
      $http.post('/CafeteriaApp.Backend/Requests/FavoriteItem.php',data)
      .then(function(response) {
        if(response.data!=="")
        {
        alertify.error( response.data);
        }
        else{

          document.getElementById(menuItemId).style.color="yellow";
        }

      });
    }
    else
    {//console.log('HI');
  
  $http.delete('/CafeteriaApp.Backend/Requests/FavoriteItem.php?Id='+menuItemId)
      .then(function(response) {
        if(response.data!=="")
        {
        alertify.error( response.data);
        }
        else{

          document.getElementById(menuItemId).style.color="red";
        }

      });


    }
    
  }

$scope.loadFavoriteItems = function() {

 $http.get('/CafeteriaApp.Backend/Requests/FavoriteItem.php')
   .then(function(response) {
       $scope.favoItems = response.data;

for (var i = $scope.menuItems.length - 1; i >= 0; i--) {
       for (var j = $scope.favoItems.length - 1; j >= 0; j--) {
         
       if($scope.menuItems[i].Id ==$scope.favoItems[j].MenuItemId)
       {
      document.getElementById($scope.menuItems[i].Id).style.color="yellow";
       }
        }

}

//var x = $scope.favoItems.filter(o => o.MenuItemId == $scope.menuItems[i].Id);  

   });

}



$scope.getCurrentCustomer();
$scope.getMenuItems();
$scope.loadFavoriteItems();


});
