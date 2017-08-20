app.controller('addCustomer',['$scope','userService','$http',function($scope,userService,$http) {

	$scope.selectedGender = 1; 
	$scope.years = Array.from(Array(68), (x,i) => i+1950);
	$scope.months = Array.from(Array(12), (x,i) => i+1);
	$scope.days = Array.from(Array(31), (x,i) => i+1);
	$scope.selectedYear = 2017;
	$scope.selectedMonth = 1;
	$scope.selectedDay = 1;

	$scope.maleInput = angular.element("#maleInput");
	$scope.femaleInput = angular.element("#femaleInput");
	
	$scope.maleInput.trigger('click');

	$scope.maleInput.on('click',function() {
		if ($scope.selectedGender != 1) {
			$scope.femaleInput.trigger('click');
			$scope.selectedGender = 1;
		}
	});

	$scope.femaleInput.on('click',function() {
		if ($scope.selectedGender != 2) {
			$scope.maleInput.trigger('click');
			$scope.selectedGender = 2;
		}
	});
	
	$scope.addCustomerUser = function () {
		$scope.$emit('getAddData'); // this is a child scope so we use $emit to send this message to the root scope
	};

	$scope.$on('addDataSent' , function () {

		// we now extract the data provided by the service and send it
		// along with the customer data to the database to insert the customer
		$scope.userData = userService.userData;
		$scope.userData.RoleId = 2; // customer role id

		$http.post('/CafeteriaApp.Backend/Requests/User.php',$scope.userData)
		.then(function(response) {

			// validate user input first
			var checkInput = $scope.userName != "" && $scope.firstName != "" && $scope.lastName != ""
			&& $scope.email != "" && $scope.phoneNumber != "" && $scope.password != ""
			&& $scope.userName == $scope.email && $scope.confirmPassword == $scope.password;
			
			if (checkInput) {

				//console.log(response);
				var dateOfBirth = String($scope.selectedYear) + '-' + String($scope.selectedMonth) + '-'
				+ String($scope.selectedDay);

				var customerData = {
					GenderId: $scope.selectedGender,
					UserId: parseInt(response.data),
					Credit: 0,
					DateOfBirth: dateOfBirth
				}

				
				$http.post('/CafeteriaApp.Backend/Requests/Customer.php',customerData)
				.then(function(response) {
					console.log(response);
					document.location = "/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
				});
			}
		});
	});
}]);