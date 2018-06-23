// controller for adding customer
add_userApp.controller('addCustomer', ['$scope', 'addUserService', '$http', function($scope, addUserService, $http) {
	$scope.credit = 0;

	$scope.maleInput = angular.element("#maleInput");
	$scope.femaleInput = angular.element("#femaleInput");
	
	$scope.maleInput.trigger('click');

	$scope.maleInput.on('click', function() {
		if ($scope.selectedGender != 1) {
			$scope.femaleInput.trigger('click');
			$scope.selectedGender = 1;
		}
	});

	$scope.femaleInput.on('click', function() {
		if ($scope.selectedGender != 2) {
			$scope.maleInput.trigger('click');
			$scope.selectedGender = 2;
		}
	});
	
	$scope.addCustomerUser = function() {
		$scope.$emit('getUserData'); // this is a child scope so we use $emit to send this message to the root scope
	};

	$scope.$on('userDataSent', function() {
		// we now extract the data provided by the service and send it
		// along with the customer data to the database to insert the customer
		$scope.userData = addUserService.userData;
		$scope.userData.RoleId = 2; // customer role id
		if ($scope.myform.$valid) {
			var customerData = {
				UserId: parseInt(response.data),
				Credit: $scope.credit,
			}
			
			$http.post('/myapi/Customer', customerData);
		}
	});
}]);