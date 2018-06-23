// controller to deal with favorite items
layoutApp.controller('favorites', ['$scope', '$http', '$rootScope', '$timeout', 'Order_Info', function($scope, $http, $rootScope, $timeout, Order_Info) {
    $scope.getFavoriteItems = function() {
        $http.get('/myapi/FavoriteItem').then(function(response) {
            $scope.favoriteItems = response.data;
        });
    };

    $scope.deleteFavorItem = function(menuItemId, index) {
        var data = {
            menuItemId: menuItemId
        };

        $http({
            method: 'DELETE',
            url: '/myapi/FavoriteItem',
            data: data,
            headers: {
                'Content-type': 'application/json;charset=utf-8'
            }
        })
        .then(function(response) {
            console.log(response);

            if (response.data == 0) {
                $scope.favoriteItems.splice(index, 1);
                Order_Info.togglePopup('Item successfully removed !');
            }
            else {
                Order_Info.togglePopup('Error occured while removing the Item !');
            }
        });
    };

    $scope.addToOrder = function(menuItemId) {
       Order_Info.addToOrder(menuItemId);
    };

    $scope.increaseQuantity = function(orderItem) {
        Order_Info.increaseQuantity(OrderItem);
    };
    
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