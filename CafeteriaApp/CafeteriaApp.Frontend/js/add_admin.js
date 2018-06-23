// controller for adding admin
add_userApp.controller('addAdmin', ['$scope', '$http', 'addUserService', function($scope, $http, addUserService) {
	$scope.addAdminUser = function() {
		$scope.$emit('getUserData'); // this is a child scope so we use $emit to send this message to the root scope
	};

	$scope.$on('userDataSent', function() {

		// we now extract the data provided by the service and send it
		// along with the customer data to the database to insert the cashier
		$scope.userData = addUserService.userData;
		$scope.userData.RoleId = 1; // admin role id

		$http.post('/myapi/User', $scope.userData)
		.then(function(response) {
			console.log(response);
			if ($scope.myform.$valid) {
				var adminData = {
					UserId: parseInt(response.data)
				};

				$http.post('/myapi/Admin', adminData)
				.then(function(response) {
					console.log(response);
					//document.location = "/admin/users";
				});
			}
		});
	});
}]);