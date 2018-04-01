
// controller for adding customer
add_userApp.controller('addCustomer',['$scope','addUserService','$http',function($scope,addUserService,$http) {

	$scope.selectedGender = 1; 
	$scope.years = Array.from(Array(68), (x,i) => i+1950);
	$scope.months = Array.from(Array(12), (x,i) => i+1);
	$scope.days = Array.from(Array(31), (x,i) => i+1);
	$scope.selectedYear = 2017;
	$scope.selectedMonth = 1;
	$scope.selectedDay = 1;
	$scope.credit = 0;

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
		$scope.$emit('getUserData'); // this is a child scope so we use $emit to send this message to the root scope
	};

	$scope.$on('userDataSent' , function () {

		// we now extract the data provided by the service and send it
		// along with the customer data to the database to insert the customer
		$scope.userData = addUserService.userData;
		$scope.userData.RoleId = 2; // customer role id

		$http.post('../../../CafeteriaApp.Backend/Requests/User.php',$scope.userData)
		.then(function(response) {
			
			if ($scope.myform.$valid) {

				var dateOfBirth = String($scope.selectedYear) + '-' + String($scope.selectedMonth) + '-'
				+ String($scope.selectedDay);

				var customerData = {
					GenderId: $scope.selectedGender,
					UserId: parseInt(response.data),
					Credit: $scope.credit,
					DateOfBirth: dateOfBirth
				}
				
				$http.post('../../../CafeteriaApp.Backend/Requests/Customer.php',customerData)
				.then(function(response) {
					document.location = "../../../CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
				});
			}
		});
	});
}]);