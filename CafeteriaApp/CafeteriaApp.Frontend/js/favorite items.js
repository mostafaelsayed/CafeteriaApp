// controller to deal with favorite items
layoutApp.controller('favorites', ['$scope', '$http', '$rootScope', '$timeout', 'Order_Info', function($scope, $http, $rootScope, $timeout, Order_Info) {
    $scope.getFavoriteItems = function() {
        $http.get('../../CafeteriaApp.Backend/Requests/FavoriteItem.php').then(function(response) {
            $scope.favoriteItems = response.data;
        });
    };
    $scope.deleteFavorItem = function(menuItemId, index) {
        $http.delete('../../CafeteriaApp.Backend/Requests/FavoriteItem.php?MenuItemId=' + menuItemId).then(function(response) {
            $scope.favoriteItems.splice(index, 1);
            Order_Info.togglePopup('Item successfully removed !');
        });
    };
    $scope.addToOrder = function(menuItemId) {
       Order_Info.addToOrder(menuItemId);
    }
    $scope.increaseQuantity = function(orderItem) {
        Order_Info.increaseQuantity(OrderItem);
    }
    $rootScope.orderItems = function() {};
    // $scope.togglePopup = function(message) {
    //   var popup = document.getElementById("myPopup");
    //   popup.innerHTML  = message;
    //   popup.classList.toggle("show");
    //   $timeout(function() {
    //     popup.classList.toggle("show");
    //   }, 2000);
    // }
    $scope.getFavoriteItems();
}]);