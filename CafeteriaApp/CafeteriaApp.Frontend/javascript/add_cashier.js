app.controller('addCashier',['$scope','$http',function($scope,$http) {

	$scope.addCashierUser = function () {
		$scope.$emit('getAddData'); // this is a child scope so we use $emit to send this message to the root scope
	};

	$scope.$on('addDataSent' , function () {

		// we now extract the data provided by the service and send it
		// along with the customer data to the database to insert the customer
		$scope.userData = userService.userData;
		$scope.userData.RoleId = 3; // cashier role id

		$http.post('/CafeteriaApp.Backend/Requests/User.php',$scope.userData)
		.then(function(response) {

			// validate user input first
			var checkInput = $scope.userName != "" && $scope.firstName != "" && $scope.lastName != ""
			&& $scope.email != "" && $scope.phoneNumber != "" && $scope.password != ""
			&& $scope.userName == $scope.email && $scope.confirmPassword == $scope.password;

			if (checkInput) {

				var cashierData = {
					UserId: parseInt(response.data)
				}

				$http.post('/CafeteriaApp.Backend/Requests/Cashier.php',cashierData)
				.then(function(response) {
					console.log(response);
					document.location = "/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
				});
				
			}

		});

	});

}]);