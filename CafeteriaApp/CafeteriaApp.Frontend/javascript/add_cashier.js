// controller for adding cashier
add_userApp.controller('addCashier',['$scope','$http','addUserService',function($scope,$http,addUserService) {

	$scope.addCashierUser = function () {
		$scope.$emit('getUserData'); // this is a child scope so we use $emit to send this message to the root scope
	};

	$scope.$on('userDataSent' , function () {

		// we now extract the data provided by the service and send it
		// along with the customer data to the database to insert the customer
		$scope.userData = addUserService.userData;
		$scope.userData.RoleId = 3; // cashier role id

		$http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/User.php',$scope.userData)
		.then(function(response) {

			if ($scope.myform.$valid) {

				var cashierData = {
					UserId: parseInt(response.data)
				}

				$http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Cashier.php',cashierData)
				.then(function(response) {
					console.log(response);
					//document.location = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
				});
				
			}

		});

	});

}]);