angular.module('cashierApp', ['ui.bootstrap', 'modal', 'angularModalService']).controller('showAndHideOrders',
['$scope', '$http', 'ModalService', function($scope, $http, ModalService) {
	$http.get('/myapi/Order/flag/1')
	.then(function(response) {
		$scope.orders = response.data;
	});

	$scope.editOrder = function(orderId) {
		$http.put( '/myapi/Order', {orderId: orderId} )
		.then(function(response) {
		  document.location = "/public/categories";
		})
	};

	$scope.hideOrder = function(order) {
		$scope.show(order);
	}

	$scope.show = function(order) {
    ModalService.showModal({
      templateUrl: '/templates/modal.html',
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
    $http.put('/myapi/Order/flag/2/orderId/' + order.Id)
    .then(function(response) {
      $scope.orders.splice($scope.orders.indexOf(order), 1);
    });
  };
}]);