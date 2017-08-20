app.controller('editUser',['$scope','$http','$location',function($scope,$http,$location) {

  $scope.userData = {};

  $scope.years = Array.from(Array(68), (x,i) => i+1950);
  $scope.months = Array.from(Array(12), (x,i) => i+1);
  $scope.days = Array.from(Array(31), (x,i) => i+1);
  $scope.selectedYear = 2017;
  $scope.selectedMonth = 1;
  $scope.selectedDay = 1;
  //$scope.maleInput = angular.element("#maleInput");
  //$scope.femaleInput = angular.element("#femaleInput");

  $scope.getRoles = function() {

    $http.get('/CafeteriaApp.Backend/Requests/Role.php')
    .then(function(response) {

      //console.log(response);
      $scope.roles = response.data;
      $scope.getUser();

    });

  };
  
  $scope.getUser = function() {

    $http.get('/CafeteriaApp.Backend/Requests/User.php?userId='+$location.search().id)
    .then(function(response) {

      //console.log(response);
      $scope.userData.userName = response.data.UserName;
      $scope.userData.firstName = response.data.FirstName;
      $scope.userData.lastName = response.data.LastName;
      $scope.userData.email = response.data.Email;
      $scope.userData.phoneNumber = response.data.PhoneNumber;
      $scope.userData.image = response.data.Image;
      $scope.userData.id = response.data.Id;
      $scope.userData.roleId = response.data.RoleId;

      $scope.originalRole = $scope.roles.filter(function(a) { // find object by property
        return a.Id == $scope.userData.roleId;
      })[0];

      $scope.selectedRole = $scope.originalRole;

      if ($scope.originalRole.Id == 2 && $scope.selectedRole != 2) {
        $scope.getCustomer();
      }

      if ($scope.originalRole.Id != 2) {
        $scope.maleInput.trigger('click');
        $scope.selectedGender = 1;
      }

    });

  };


  $scope.maleInput = angular.element("#maleInput");
  $scope.femaleInput = angular.element("#femaleInput");
 
  $scope.maleInput.on('click',function() {

    if ($scope.selectedGender == 2) {
      $scope.femaleInput.trigger('click');
    }

    $scope.selectedGender = 1;

  });

  $scope.femaleInput.on('click',function() {

    if ($scope.selectedGender == 1) {
      $scope.maleInput.trigger('click');
    }

    $scope.selectedGender = 2;

  });

  $scope.getCustomer = function() {

    $http.get('/CafeteriaApp.Backend/Requests/Customer.php?userId='+($location.search().id))
    .then(function(response) {

      //console.log(response);
      $scope.selectedGender = response.data.GenderId;
      $scope.credit = response.data.Credit;
      if ($scope.selectedGender == 1) {
        $scope.maleInput.trigger('click');
      }
      if ($scope.selectedGender == 2) {
        $scope.femaleInput.trigger('click');
      }

      var s = response.data.DateOfBirth.split('-');
      $scope.selectedYear = parseInt((s[0])); // should be pasrsed as number because years array is array of numbers
      $scope.selectedMonth = parseInt(s[1]);
      $scope.selectedDay = parseInt(s[2]);

    });

  };

  $scope.getRoles();

  $scope.save = function () {
    
    var checkInput =  $scope.userData.userName != "" && $scope.userData.firstName != ""
    && $scope.userData.lastName != "" && $scope.userData.email != ""
    && $scope.userData.phoneNumber != "";
    console.log($scope.selectedGender);
    
    if (checkInput) {

      var userData = {
        UserName: $scope.userData.userName,
        FirstName: $scope.userData.firstName,
        LastName: $scope.userData.lastName,
        Email: $scope.userData.email,
        PhoneNumber: $scope.userData.phoneNumber,
        Id: parseInt($scope.userData.id),
        RoleId: $scope.selectedRole.Id,
        Image: $scope.userData.image
      };

      $http.put('/CafeteriaApp.Backend/Requests/User.php',userData)
      .then(function(response) {
        console.log(response);
      });

      if ($scope.selectedRole.Id == $scope.originalRole.Id) {

        var x = $scope.selectedRole.Id;
        // add any specific attributes in the data object
          if (x == 2) {

            var customerData = {
              Credit: $scope.credit,
              UserId: parseInt($scope.userData.id),
              DateOfBirth: String($scope.selectedYear) + '-' + String($scope.selectedMonth) + '-' + String($scope.selectedDay),
              GenderId: parseInt($scope.selectedGender)
            };

            //console.log(customerData);
            $http.put('/CafeteriaApp.Backend/Requests/Customer.php',customerData)
            .then(function(response) {
              console.log(response);
              window.history.back();
            });

          }

          else if (x == 1) { // admin role
            window.history.back();
          }

          else if (x == 3) { // cashier role
            window.history.back();
          }

      }

      else { // selected is not as original

        if ($scope.originalRole.Id == 1) { // admin role

          $http.delete('/CafeteriaApp.Backend/Requests/Admin.php?userId='+$location.search().id)
          .then(function(response) {
            console.log(response);
          });

        }

        else if ($scope.originalRole.Id == 2) { // customer role

          $http.delete('/CafeteriaApp.Backend/Requests/Customer.php?userId='+$location.search().id)
          .then(function(response) {
            console.log(response);
          });
          
        }

        else if ($scope.originalRole.Id == 3) { // cashier role

          $http.delete('/CafeteriaApp.Backend/Requests/Cashier.php?userId='+$location.search().id)
          .then(function(response) {
            console.log(response);
          });
          
        }

        if ($scope.selectedRole.Id == 1) {

          var adminData = {
            UserId: $scope.userData.id
          };

          $http.post('/CafeteriaApp.Backend/Requests/Admin.php',adminData)
          .then(function(response) {
            console.log(response);
            window.history.back();
          });

          $scope.originalRole = $scope.selectedRole;

        }

        else if ($scope.selectedRole.Id == 2) {

          var customerData = {
            Credit: $scope.credit,
            DateOfBirth: String($scope.selectedYear) + '-' + String($scope.selectedMonth) + '-'
            + String($scope.selectedDay),
            UserId: $scope.userData.id,
            GenderId: parseInt($scope.selectedGender)
          };
          console.log(customerData);

          $http.post('/CafeteriaApp.Backend/Requests/Customer.php',customerData)
          .then(function(response) {
            console.log(response);
            window.history.back();
          });

          $scope.originalRole = $scope.selectedRole;

        }

        else if ($scope.selectedRole.Id == 3) {

          var cashierData = {
            UserId: $scope.userData.id
          };

          $http.post('/CafeteriaApp.Backend/Requests/Cashier.php',cashierData)
          .then(function(response) {
            console.log(response);
            window.history.back();
          });

          $scope.originalRole = $scope.selectedRole;

        }

      }

    }

  };

}]);