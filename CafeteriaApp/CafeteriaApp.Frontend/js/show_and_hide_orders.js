angular.module('cashierApp', ['ui.bootstrap', 'modal', 'angularModalService']).controller('showAndHideOrders',
['$scope', '$http', 'ModalService', function($scope, $http, ModalService) {

	$http.get('../../CafeteriaApp.Backend/Requests/Order.php?flag=1')
	.then(function(response) {
		$scope.orders = response.data;
	});

	$scope.editOrder = function(orderId) {
		$http.put( '../../CafeteriaApp.Backend/Requests/Order.php', {orderId: orderId} )
		.then(function(response) {
			document.location = "../../CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";
		})
	};

	$scope.hideOrder = function(order) {
		$scope.show(order);
	}

	$scope.show = function(order) {

    ModalService.showModal({
      templateUrl: '../../CafeteriaApp.Frontend/Templates/Views/modal.html',
      controller: "ModalController",
      inputs: {
        name: "order"
      }
      
    }).then(function(modal) {
      modal.element.modal();

      modal.close.then(function(result) {
        if (result == "Yes") {
          $scope.delete(order);
        }
      });
    });
  };

  $scope.delete = function(order) { // this will close order not delete it
     $http.put('../../CafeteriaApp.Backend/Requests/Order.php?flag=2&orderId=' + order.Id)
     .then(function(response) {
       $scope.orders.splice($scope.orders.indexOf(order), 1);
     });
    };
}]);