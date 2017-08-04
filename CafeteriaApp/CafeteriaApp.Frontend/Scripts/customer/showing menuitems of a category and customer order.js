var app = angular.module('myapp', []);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

// controller for getting menuitems of a category from database

app.controller('getMenuItemsAndCustomerOrder', function ($scope,$http,$location) {
  $scope.categoryId = $location.search().id;

  $scope.getMenuItems = function() {
   $http.get('/CafeteriaApp.Backend/Requests/MenuItem.php?categoryId='+$scope.categoryId)
   .then(function(response) {
       $scope.menuItems = response.data;
   });
  }

  $scope.getMenuItems();

  $scope.getCurrentCustomer = function() {
    $http.get('/CafeteriaApp.Backend/Requests/Customer.php')
    .then(function(response) {
      $scope.customerId = response.data.Id;
      console.log($scope.customerId);
      if ($scope.customerId == undefined) {
        document.location = "/CafeteriaApp.Frontend/Views/login.php";
      }
      else {
        //console.log($scope.customerId);
        $scope.getOrder();
      }
    });
  }

  $scope.getTotalPrice = function() {
    // var price = 0;
    // for (i = 0;i<$scope.orderItems.length;i++) {
    //   if ($scope.orderItems[i] != null) {
    //     price = price + $scope.orderItems[i].Quantity*$scope.orderItems[i].Price;
    //   }
    // }
    // return price;
  }

  $scope.getOrderItems = function() {
    $http.get('/CafeteriaApp.Backend/Requests/OrderItem.php?orderId='+$scope.orderId)
    .then(function(response) {
      console.log(response.data);
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
      // else if ($scope.orderId == undefined) {
      //   $scope.orderItems = [];
      //   //console.log($scope.orderItems);
      //   $scope.TotalPrice = 0;
      // }
    });
  }

  $scope.getCurrentCustomer();

  $scope.addToOrder = function(menuItem) {
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
    //console.log(orderItem.Id);
    if($scope.orderId != null) {
      var data = {
        Id: orderItem.Id,
        Quantity: parseInt(orderItem.Quantity)+1,
        Flag: true
      };
      $http.put('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
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

});
