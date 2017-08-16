app.controller('editUser',['$scope','$http','$location',function($scope,$http,$location){

  // $scope.image = null;

  // $scope.imageFileName = '';
  $scope.selectedGender = 1;
  $scope.roles = ["Customer","Admin","Cashier"];
  $scope.selectedRole = "Admin";
  // $scope.uploadme = {};
  // $scope.uploadme.src = '';
  $scope.userId = $location.search().id;

  // $scope.maleChecked = function () {
  //   if ($scope.selectedGender != 1) {
  //     if ($scope.selectedGender == 2) {
  //       angular.element("#femaleInput").trigger('click');
  //     }
  //     $scope.selectedGender = 1;

  //   }
  // }

  // $scope.femaleChecked = function () {
  //   if ($scope.selectedGender != 2) {
  //     if ($scope.selectedGender == 1) {
  //       angular.element("#maleInput").trigger('click');
  //     }
  //     $scope.selectedGender = 2;
  //   }
  // }
  
  $scope.getUser = function() {
    $http.get('/CafeteriaApp.Backend/Requests/User.php?userId='+$scope.userId)
    .then(function(response){
      console.log(response);
      if (response.data.RoleId == 1) {
        $scope.selectedRole = "Admin";
      }
      else if (response.data.RoleId == 2) {
        $scope.selectedRole = "Cashier";
      }
      else if (response.data.RoleId == 3) {
        $scope.selectedRole = "Customer";
      }
      $scope.userName = response.data.UserName;
      $scope.firstName = response.data.FirstName;
      $scope.lastName = response.data.LastName;
      $scope.email = response.data.Email;
      $scope.image = response.data.Image;
      $scope.roleId = response.data.RoleId;
      $scope.phoneNumber = response.data.PhoneNumber;
    })
  }

  $scope.getUser();

  $scope.editUser = function() {
    var checkEmpty =  $scope.userName != "" && $scope.firstName != "" && $scope.lastName != ""
    && $scope.email != "" && $scope.phoneNumber != "" && $scope.image != null;
    var checkRole = $scope.selectedRole == "Customer" || $scope.selectedRole == "Admin"
    || $scope.selectedRole == "Cashier";
    if (checkEmpty && checkRole) {
      if ($scope.selectedRole == "Admin") {
        $scope.roleId = 1;
      }
      else if ($scope.selectedRole == "Cashier") {
        $scope.roleId = 2;
      }
      else if ($scope.selectedRole == "Customer") {
        $scope.roleId = 3;
      }
      // var x = "";
      // if ($scope.uploadme.src != '') {
      //   x = $scope.uploadme.src.split(',')[1];
      // }
      // else {
      //   x = $scope.imageUrl;
      // }
      var data = {
        UserName: $scope.userName,
        FirstName: $scope.firstName,
        LastName: $scope.lastName,
        Email: $scope.email,
        Image: $scope.image,
        PhoneNumber: $scope.phoneNumber,
        RoleId: $scope.roleId,
        Id: $scope.userId
      };
      $http.put('/CafeteriaApp.Backend/Requests/User.php',data)
      .then(function(response){
        window.history.back();
      });
    }
  };
}]);