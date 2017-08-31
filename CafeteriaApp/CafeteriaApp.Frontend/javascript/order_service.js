var order_serviceApp = angular.module('order_service',[]);

order_serviceApp.factory('Order_Info' , ['$http','$rootScope',function($http,$rootScope) {

  var order_info = {};
  //order_info.orderItems = [];
  //order_info.orderId = 0;

  order_info.getOrderItems = function(orderId) { // this is asyhnchronous
   // var q = $q.defer();
   //return  $http.get('/CafeteriaApp.Backend/Requests/OrderItem.php?orderId='+orderId)
   $http.get('/CafeteriaApp.Backend/Requests/OrderItem.php?orderId='+orderId).success(function(data) { 
      $rootScope.orderItems=data;

           }).error(function(){
               alert('something went wrong!!!');
           });
   // .then(function(response) {
        //console.log(response);
        //order_info.orderItems=response.data;
       // return response.data;
        // if (order_info.orderItems != null) {
        //   q.resolve(1);
        // }
        // else {
        //   q.reject(0);
        // }
    //});
    //return q.promise;
  };


// order_info.set=function (argument) {
//   order_info.orderItems =argument;
// };

// order_info.get=function () {
//   return order_info.orderItems ;
// };

  order_info.increaseQuantity = function(orderItem) {
    if(orderItem.OrderId != null) {
      var data = {
        Id: orderItem.Id,
        Quantity: parseInt(orderItem.Quantity)+1,
        Flag: true
      };
      $http.put('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {

        order_info.getOrderItems(orderItem.OrderId);
       
        //$rootScope.$broadcast('loadOrderItems',order_info.orderItems);
      });
    }
  }


  order_info.decreaseQuantity = function(orderItem) {
    console.log(orderItem);
    var data = {
      Id: orderItem.Id,
      Quantity: parseInt(orderItem.Quantity)-1,
      Flag: false
    };
    if (orderItem.Quantity > 1) {
      $http.put('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
          order_info.getOrderItems(orderItem.OrderId);
      });
    }
    else {
      order_info.deleteOrderItem(orderItem);
    }
  }


  order_info.deleteOrderItem = function(orderItem) {
    $http.delete('/CafeteriaApp.Backend/Requests/OrderItem.php?id='+orderItem.Id)
    .then(function(response) {
      order_info.getOrderItems(orderItem.OrderId);
    });
  }

  return order_info;

}]);
