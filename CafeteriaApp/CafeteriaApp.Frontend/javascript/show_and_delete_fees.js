var show_and_delete_feesApp = angular.module('show_and_delete_fees',['modal','angularModalService','ui.bootstrap']);

show_and_delete_feesApp.controller('showAndDeleteFees',['$scope','$http','ModalService',function($scope,$http,ModalService) {

	$scope.show = function() {

    ModalService.showModal({
      templateUrl: '/CafeteriaApp.Frontend/Templates/Views/modal.html',
      controller: "ModalController",
      inputs: {
        name: "fee"
      }

  	}).then(function(modal) {

    	modal.element.modal();

    	modal.close.then(function(result) {
      	if (result == "Yes") {
        	$scope.delete();
      	}
    	});

  	});

  };

	$scope.getFees = function() {

		$http.get('/CafeteriaApp.Backend/Requests/Fee.php')
		.then(function(response) {
			$scope.fees = response.data;
		});

	};

	$scope.getFees();

	$scope.deleteFee = function(fee) {

    	$scope.show();

    	$scope.delete = function() {

     		$http.delete('/CafeteriaApp.Backend/Requests/Fee.php?feeId='+fee.Id)
     		.then(function(response) {
       		$scope.fees.splice($scope.fees.indexOf(fee),1);
     		});

    	};

  	};

}]);