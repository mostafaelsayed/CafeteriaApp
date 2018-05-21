var edit_userApp = angular.module('edit_user', ['image', 'registerFormValidation']);

// controller for editing user
edit_userApp.controller('editUser', ['$scope', '$http', function($scope, $http) {

  $scope.userData = {imageUrl: ''};
  $scope.userId = $.urlParam('id');

  $scope.roles = [{'id': 1, 'name': 'Admin'}, {'id': 2, 'name': 'Customer'}, {'id': 3, 'name': 'Cashier'}];

  // customer info
  $scope.years = Array.from(Array(68), (x,i) => i + 1950);
  $scope.months = Array.from(Array(12), (x,i) => i + 1);
  $scope.days = Array.from(Array(31), (x,i) => i + 1);
  $scope.selectedYear = {year: 2017};
  $scope.selectedMonth = {month: 1};
  $scope.selectedDay = {day: 1};
  $scope.credit = 0;

  $scope.getUser = function() {
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/User.php?userId=' + $scope.userId)
    .then(function(response) {
      console.log(response);
      $scope.userData.firstName = response.data.FirstName;
      $scope.userData.lastName = response.data.LastName;
      $scope.userData.email = response.data.Email;
      $scope.em = $scope.userData.email;
      $scope.userData.phoneNumber = response.data.PhoneNumber;
      $scope.userData.imageUrl = response.data.Image;
      $scope.userData.id = response.data.Id;
      $scope.userData.role = response.data.RoleId;
      $scope.selectedGender = response.data.GenderId;
      $scope.dateOfBirth = response.data.DateOfBirth;

      $scope.originalRole = $scope.roles.filter(function(a) { // find object by property
        return a.id == $scope.userData.role;
      })[0];

      $scope.selectedRole = $scope.originalRole;

      if ($scope.selectedGender == 1) {
        angular.element('#maleInput').trigger('click');
      }

      if ($scope.selectedGender == 2) {
        angular.element('#femaleInput').trigger('click');
      }

      var s = $scope.dateOfBirth.split('-');
      $scope.selectedYear = {year: parseInt(s[0])}; // should be pasrsed as number because years array is array of numbers
      $scope.selectedMonth = {month: parseInt(s[1])};
      $scope.selectedDay = {day: parseInt(s[2])};

      console.log($scope.originalRole);
      console.log($scope.selectedRole);

      if ($scope.originalRole.id == 2 && $scope.selectedRole.id == 2) {
        $scope.getCustomer();
      }
    });
  };

  $scope.$watchGroup(['selectedYear.year', 'selectedMonth.month', 'selectedDay.day'], function(newVal, oldVal) {
    $scope.dob = $scope.selectedYear.year + '-' + $scope.selectedMonth.month + '-' + $scope.selectedDay.day;
    angular.element('#dob').val($scope.dob);
  }, true);

  $scope.getUser();

  $scope.getCustomer = function() {
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Customer.php?userId=' + $scope.userId)
    .then(function(response) {
      $scope.credit = response.data.Credit;
    });
  };

  $scope.save = function () {
    if ($scope.myform.$valid) {

      var userData = {
        FirstName: $scope.userData.firstName,
        LastName: $scope.userData.lastName,
        Email: $scope.userData.email,
        PhoneNumber: $scope.userData.phoneNumber,
        Id: parseInt($scope.userData.id),
        RoleId: $scope.selectedRole.id,
        Image: $('#image').attr('src'),
        DateOfBirth: String($scope.selectedYear.year) + '-' + String($scope.selectedMonth.month) + '-' + String($scope.selectedDay.day),
        GenderId: parseInt($scope.selectedGender)
      };

      if ($('#file').val() == '') {
        userData.Image = '';
      }

      //console.log(userData);

      $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/User.php', userData)
      .then(function(response) {
        //window.history.back();
        //console.log(response);
      });

      if ($scope.selectedRole.id == $scope.originalRole.id) {
        var x = $scope.selectedRole.id;
        // add any specific attributes in the data object
        if (x == 2) {
          var customerData = {
            Credit: $scope.credit,
            UserId: parseInt($scope.userData.id),
          };

          $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Customer.php', customerData)
          .then(function(response) {
            console.log(response);
            // window.history.back();
          });

          window.history.back();
        }
        else if (x == 1) { // admin role
          window.history.back();
        }
        else if (x == 3) { // cashier role
          window.history.back();
        }
      }
      else { // selected is not as original
        if ($scope.originalRole.id == 1) { // admin role
          $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Admin.php?userId=' + $scope.userId)
          .then(function(response) {
          });
        }
        else if ($scope.originalRole.id == 2) { // customer role
          $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Customer.php?userId=' + $scope.userId)
          .then(function(response) {
          });
        }
        else if ($scope.originalRole.id == 3) { // cashier role
          $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Cashier.php?userId=' + $scope.userId)
          .then(function(response) {
          });
        }

        if ($scope.selectedRole.id == 1) {
          var adminData = {
            UserId: $scope.userData.id
          };

          $http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Admin.php', adminData)
          .then(function(response) {
            // window.history.back();
          });

          window.history.back();

          $scope.originalRole = $scope.selectedRole;
        }
        else if ($scope.selectedRole.id == 2) {
          var customerData = {
            Credit: $scope.credit,
            UserId: $scope.userData.id,
          };

          $http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Customer.php', customerData)
          .then(function(response) {
            //window.history.back();
          });

          window.history.back();

          $scope.originalRole = $scope.selectedRole;
        }
        else if ($scope.selectedRole.id == 3) {
          var cashierData = {
            UserId: $scope.userData.id
          };

          $http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Cashier.php', cashierData)
          .then(function(response) {
            //window.history.back();
          });

          window.history.back();

          $scope.originalRole = $scope.selectedRole;
        }
      }
    }
  };
}]);