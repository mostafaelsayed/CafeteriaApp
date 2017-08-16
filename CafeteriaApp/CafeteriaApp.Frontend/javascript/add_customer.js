app.controller('addCustomer',['$scope','userService','$http',function($scope,userService,$http) {

	$scope.image = "";
	$scope.selectedGender = 1; 
	$scope.years = Array.from(Array(68), (x,i) => i+1950);
	$scope.months = Array.from(Array(12), (x,i) => i+1);
	$scope.days = Array.from(Array(31), (x,i) => i+1);
	$scope.selectedYear = 2017;
	$scope.selectedMonth = 1;
	$scope.selectedDay = 1;

	angular.element("#maleInput").trigger('click');

	$scope.maleChecked = function () {
		if ($scope.selectedGender != 1) {
			if ($scope.selectedGender == 2) {
				angular.element("#femaleInput").trigger('click');
			}
			$scope.selectedGender = 1;

		}
	};

	$scope.femaleChecked = function () {
		if ($scope.selectedGender != 2) {
			if ($scope.selectedGender == 1) {
				angular.element("#maleInput").trigger('click');
			}
			$scope.selectedGender = 2;
		}
	};
	
	$scope.addCustomerUser = function () {
		$scope.$emit('getData'); // this is a child scope so we use $emit to broadcast this message to the root scope	
	};

	$scope.$on('dataSent' , function () {
		var dateOfBirth = String($scope.selectedYear) + '-' + String($scope.selectedMonth) + '-'
		+ String($scope.selectedDay);
		$scope.userData = userService.UserData; // we extract the data from provided by the service and send it
		// along with the customer data to the database to insert the customer
		console.log($scope.userData);
		//$scope.userData.Image = $scope.image;
		$scope.userData.GenderId = $scope.selectedGender;
		$scope.userData.DateOfBirth = dateOfBirth;
		// validate data ... 

		$http.post('/CafeteriaApp.Backend/Requests/Customer.php',$scope.userData)
		.then(function(response) {
			console.log(response);
			document.location = "/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
		});
	});
}]);