app.controller('addUser',['$scope','$http',function($scope,$http) {

	$scope.userName = "";
	$scope.firstName = "";
	$scope.lastName = "";
	$scope.email = "";
	$scope.phoneNumber = "";
	$scope.password = "";
	$scope.confirmPassword = "";

	$scope.$on('getYourAddData',function() {

		var data = {
			UserName: $scope.userName,
			FirstName: $scope.firstName,
			LastName: $scope.lastName,
			Image: "image",
			Email: $scope.email,
			Password: $scope.password,
			PhoneNumber: $scope.phoneNumber
		};

		$scope.$emit('hereIsMyAddData',data);

	});
	
}]);