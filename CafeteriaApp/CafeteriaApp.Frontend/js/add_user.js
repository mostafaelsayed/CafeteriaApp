var add_userApp = angular.module('add_user', ['registerFormValidation', 'ngRoute']);

add_userApp.config(['$locationProvider', '$routeProvider', function($locationProvider, $routeProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });

  $routeProvider
  // add user
  .when('/admin/users/add/1', {
    templateUrl: '/templates/add_admin.php',
  })

  .when('/admin/users/add/2', {
    templateUrl: '/templates/add_cashier.php',
  })
  
  .when('/admin/users/add/3', {
    templateUrl: '/templates/add_customer.php',
  })
}]);

// add_userApp.factory('addUserService', ['$rootScope', function($rootScope) {

//   var userServiceInstance = {};
//   userServiceInstance.userData = {};

//   $rootScope.$on('getUserData', function() {
//     $rootScope.$broadcast('getYourUserData');
//   });

//   $rootScope.$on('hereIsMyUserData', function(event, data) {
//     userServiceInstance.userData = data;
//     $rootScope.$broadcast('userDataSent');
//   });

//   return userServiceInstance;
// }]);

// controller for adding user
add_userApp.controller('addUser', ['$scope', '$http', function($scope, $http) {
	$scope.firstName = "";
	$scope.lastName = "";
	$scope.email = "";
	$scope.phoneNumber = "";
	$scope.password = "";
	$scope.confirmPassword = "";
  $scope.years = Array.from(Array(68), (x,i) => i + 1950);
  $scope.months = Array.from(Array(12), (x,i) => i + 1);
  $scope.days = Array.from(Array(31), (x,i) => i + 1);
  $scope.selectedYear = {year: 2017};
  $scope.selectedMonth = {month: 1};
  $scope.selectedDay = {day: 1};

  $scope.maleInput = angular.element("#maleInput");
  $scope.femaleInput = angular.element("#femaleInput");
  
  $scope.maleInput.trigger('click');

  $scope.dob = $scope.selectedYear.year + '-' + $scope.selectedMonth.month + '-' + $scope.selectedDay.day;
  angular.element('#dob').val($scope.dob);

  angular.element('#role').val( window.location.href.substr(window.location.href.lastIndexOf('/') + 1) );

  // must use properities not the object to detect changes
  $scope.$watchGroup(['selectedYear.year', 'selectedMonth.month', 'selectedDay.day'], function(newVal, oldVal) {
    $scope.dob = $scope.selectedYear.year + '-' + $scope.selectedMonth.month + '-' + $scope.selectedDay.day;
    angular.element('#dob').val($scope.dob);
  }, true);
}]);