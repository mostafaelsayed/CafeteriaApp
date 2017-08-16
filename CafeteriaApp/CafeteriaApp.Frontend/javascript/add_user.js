app.controller('addUser',['$scope','$http',function($scope,$http) {

	$scope.userName = "";
	$scope.firstName = "";
	$scope.lasstName = "";
	$scope.email = "";
	$scope.phoneNumber = "";
	$scope.password = "";
	$scope.confirmPassword = "";
	$scope.image = "";
	$scope.selectedGender = 1; 
	$scope.years = Array.from(Array(68), (x,i) => i+1950);
	$scope.months = Array.from(Array(12), (x,i) => i+1);
	$scope.days = Array.from(Array(31), (x,i) => i+1);
	$scope.selectedYear = 2017;
	$scope.selectedMonth = 1;
	$scope.selectedDay = 1;
	$scope.roles = ["Customer","Admin","Cashier"];
	$scope.selectedRole = "Customer";

	angular.element("#maleInput").trigger('click');

	

	$scope.maleChecked = function () {
		if ($scope.selectedGender != 1) {
			if ($scope.selectedGender == 2) {
				angular.element("#femaleInput").trigger('click');
			}
			$scope.selectedGender = 1;

		}
	}

	$scope.femaleChecked = function () {
		if ($scope.selectedGender != 2) {
			if ($scope.selectedGender == 1) {
				angular.element("#maleInput").trigger('click');
			}
			$scope.selectedGender = 2;
		}
	}
	
	$scope.addUser = function () {
		var checkEmpty =  $scope.userName != "" && $scope.firstName != "" && $scope.lastName != ""
		&& $scope.email != "" && $scope.phoneNumber != "" && $scope.password != ""
		&& $scope.confirmPassword != "";
		var checkRole = $scope.selectedRole == "Customer" || $scope.selectedRole == "Admin"
		|| $scope.selectedRole == "Cashier";
		// we also need to check the format of email and phonenumber later
		if (checkEmpty && checkRole && ($scope.password == $scope.confirmPassword)) {
			var data = {
				UserName: $scope.userName,
				FirstName: $scope.firstName,
				LastName: $scope.lastName,
				Email: $scope.email,
				DateOfBirth: String($scope.selectedYear) + '-' + String($scope.selectedMonth) + '-'
				+ String($scope.selectedDay),
				GenderId: $scope.selectedGender,
				Password: $scope.password,
				//Image: $scope.image,
				PhoneNumber: $scope.phoneNumber
			}
			if ($scope.selectedRole == "Customer") {
				$http.post('/CafeteriaApp.Backend/Requests/Customer.php',data)
				.then(function(response) {
					console.log(response);
					document.location = "/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
				})
			}
			else if ($scope.selectedRole == "Admin") {
				delete data['DateOfBirth'];
				delete data['GenderId'];
				$http.post('/CafeteriaApp.Backend/Requests/Admin.php',data)
				.then(function(response) {
					console.log(response);
					document.location = "/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
				})
			}
			
			else if ($scope.selectedRole == "Cashier") {
				delete data['DateOfBirth'];
				delete data['GenderId'];
				$http.post('/CafeteriaApp.Backend/Requests/Cashier.php',data)
				.then(function(response) {
					console.log(response);
					document.location = "/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
				})
			}
		}
	}
}]);