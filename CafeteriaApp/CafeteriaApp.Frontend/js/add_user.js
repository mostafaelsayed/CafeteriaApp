var add_userApp = angular.module('add_user', ['image', 'ngRoute', 'phone_number', 'price']);

add_userApp.config(['$routeProvider', function($routeProvider) {

  $routeProvider
  // add user
  .when("../../CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/1" , {
    templateUrl: "../../CafeteriaApp.Frontend/Templates/Views/add_admin.php",
    controller: "addAdmin"
  })

  .when("../../CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/2", {
    templateUrl: "../../CafeteriaApp.Frontend/Templates/Views/add_cashier.php",
    controller: "addCashier"
  })
  
  .when("../../CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/3", {
    templateUrl: "../../CafeteriaApp.Frontend/Templates/Views/add_customer.php",
    controller: "addCustomer"
  })
  
}]);

add_userApp.factory('addUserService',['$rootScope',function($rootScope) {

  var userServiceInstance = {};
  userServiceInstance.userData = {};

  $rootScope.$on('getUserData',function() {
    $rootScope.$broadcast('getYourUserData');
  });

  $rootScope.$on('hereIsMyUserData',function(event,data) {
    userServiceInstance.userData = data;
    $rootScope.$broadcast('userDataSent');
  });

  return userServiceInstance;
  
}]);

// controller for adding user
add_userApp.controller('addUser', ['$scope', '$http', function($scope, $http) {

	$scope.userName = "";
	$scope.firstName = "";
	$scope.lastName = "";
	$scope.email = "";
	$scope.phoneNumber = "";
	$scope.password = "";
	$scope.confirmPassword = "";
  $scope.uploadme = {};
  $scope.uploadme.src = '';

	$scope.$on('getYourUserData',function() {

		var data = {
			UserName: $scope.userName,
			FirstName: $scope.firstName,
			LastName: $scope.lastName,
			Image: $scope.uploadme.src.split(',')[1],
			Email: $scope.email,
			Password: $scope.password,
      ConfirmPassword: $scope.confirmPassword,
			PhoneNumber: $scope.phoneNumber
		};

		$scope.$emit('hereIsMyUserData',data);

	});
	
}]);