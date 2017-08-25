app.controller('addAdmin',['$scope','$http','userService',function($scope,$http,userService) {
	
	$scope.addAdminUser = function () {
		$scope.$emit('getUserData'); // this is a child scope so we use $emit to send this message to the root scope
	};

	$scope.$on('userDataSent' , function () {

		// we now extract the data provided by the service and send it
		// along with the customer data to the database to insert the cashier
		$scope.userData = userService.userData;
		$scope.userData.RoleId = 1; // admin role id

		$http.post('/CafeteriaApp.Backend/Requests/User.php',$scope.userData)
		.then(function(response) {

			// validate user input first
			var checkInput = $scope.userData.userName != "" && $scope.userData.firstName != ""
			&& $scope.userData.lastName != "" && $scope.userData.email != ""
			&& $scope.userData.phoneNumber != "" && $scope.userData.password != ""
			&& $scope.userData.userName == $scope.userData.email
			&& $scope.userData.confirmPassword == $scope.userData.password;

			if (checkInput) {

				var adminData = {
					UserId: parseInt(response.data)
				}

				$http.post('/CafeteriaApp.Backend/Requests/Admin.php',adminData)
				.then(function(response) {
					console.log(response);
					document.location = "/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
				});

			}

		});

	});

}]);