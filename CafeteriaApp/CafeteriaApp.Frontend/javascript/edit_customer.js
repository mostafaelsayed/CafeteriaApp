app.controller('editCustomer',['$scope','$http','userService','$location',function($scope,$http,userService,$location) {

  $scope.userData = {};
  $scope.years = Array.from(Array(68), (x,i) => i+1950);
  $scope.months = Array.from(Array(12), (x,i) => i+1);
  $scope.days = Array.from(Array(31), (x,i) => i+1);
  $scope.roles = ["Customer","Admin","Cashier"];
  $scope.selectedRole = "Customer";

  $http.get('/CafeteriaApp.Backend/Requests/Customer.php?userId='+$location.search().id)
  .then(function(response) {

    console.log(response);
    $scope.genderId = response.data.GenderId;

    if ($scope.genderId == 1) {
      angular.element("#maleInput").trigger('click');
    }

    if ($scope.genderId == 2) {
      angular.element("#femaleInput").trigger('click');
    }

    $scope.maleChecked = function () {
      if ($scope.genderId != 1) {
        if ($scope.genderId == 2) {
          angular.element("#femaleInput").trigger('click');
        }

        $scope.genderId = 1;

      }
    };

    $scope.femaleChecked = function () {
      if ($scope.genderId != 2) {
        if ($scope.genderId == 1) {
          angular.element("#maleInput").trigger('click');
        }
        $scope.genderId = 2;
      }
    };

    

    var s = response.data.DateOfBirth.split('-');
    $scope.selectedYear = parseInt((s[0])); // should be pasrsed as number because years array is array of numbers
    $scope.selectedMonth = parseInt(s[1]);
    $scope.selectedDay = parseInt(s[2]);
    $scope.dateOfBirth = String($scope.selectedYear) + '-' + String($scope.selectedMonth) + '-'
    + String($scope.selectedDay);
    console.log($scope.selectedYear);

  });

  $scope.save = function () {
    $scope.$emit('getData');
  };

  $scope.$on('dataSent',function() {

    $scope.userData.userName = userService.UserData.userName;
    $scope.userData.firstName = userService.UserData.firstName;
    $scope.userData.lastName = userService.UserData.lastName;
    $scope.userData.email = userService.UserData.email;
    $scope.userData.phoneNumber = userService.UserData.phoneNumber;
    $scope.userData.id = userService.UserData.id;
    $scope.userData.image = userService.UserData.image;
    $scope.userData.roleId = userService.UserData.roleId;

    var checkInput =  $scope.userData.userName != "" && $scope.userData.firstName != ""
    && $scope.userData.lastName != "" && $scope.userData.email != ""
    && $scope.userData.phoneNumber != "";

    if (checkInput) {
      // console.log($scope.userData);
      // add any specific attributes in the data object
      var data = {
        UserName: $scope.userData.userName,
        FirstName: $scope.userData.firstName,
        LastName: $scope.userData.lastName,
        Email: $scope.userData.email,
        PhoneNumber: $scope.userData.phoneNumber,
        Id: parseInt($scope.userData.id),
        Credit: 0,
        DateOfBirth: $scope.dateOfBirth,
        GenderId: parseInt($scope.genderId),
        RoleId: $scope.userData.roleId,
        Image: $scope.userData.image
      };

      $http.put('/CafeteriaApp.Backend/Requests/User.php',data)
      .then(function(response) {
        console.log(response);
        window.history.back();
      });

    }

  });
}]);