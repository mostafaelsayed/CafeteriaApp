angular.module('customer_and_cashier_order', []).factory('Order_Info', ['$interval', '$http', '$rootScope', '$timeout', function ($interval, $http, $rootScope, $timeout) {
  var order_info = {};

  order_info.getOrderItems = function(orderId) { // this is asyhnchronous
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderItem.php?orderId=' + orderId).success(function(data) {
      $rootScope.orderItems = data;
    });
  };

  order_info.togglePopup = function(message) {
    var popup = document.getElementById("myPopup");
    popup.innerHTML = message;
    popup.classList.toggle("show");
    $timeout(function() {
      popup.classList.toggle("show");
    }, 2000);
  };

  order_info.increaseQuantity = function(orderItem) {
    if (orderItem.OrderId != null) {
      var data = {
        Id: orderItem.Id,
        Quantity: parseInt(orderItem.Quantity) + 1,
        Flag: true
      };

      $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderItem.php', data)
      .then(function(response) {
        order_info.getOrderItems(orderItem.OrderId);
      });
    }
  };

  order_info.decreaseQuantity = function(orderItem) {
    var data = {
      Id: orderItem.Id,
      Quantity: parseInt(orderItem.Quantity) - 1,
      Flag: false
    };

    if (orderItem.Quantity > 1) {
      $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderItem.php', data)
      .then(function(response) {
        order_info.getOrderItems(orderItem.OrderId);
      });
    }
    else {
      order_info.deleteOrderItem(orderItem);
    }
  };

  order_info.deleteOrderItem = function(orderItem) {
    $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderItem.php?id=' + orderItem.Id)
    .then(function(response) {
      order_info.getOrderItems(orderItem.OrderId);
    });
  };

  return order_info;
}]);