var registerApp = angular.module('register',[]);

registerApp.controller('Register',['$scope','$http',function($scope,$http) {

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  $scope.imageVisible = 1;

  $scope.checkExistingMailAndUserName = function () {

    var data = { // date need to be updated also
      userName: $scope.userName,
      email: $scope.email
    };

    $http.post('/CafeteriaApp.Backend/Requests/Register.php',data) 
    .then(function(response) {

      if (response.data === "") {
        $scope.registerfn();
      }

      else {
        alertify.error(response.data);
        return false;
      }

    });

  };

  $scope.registerfn = function () {
  console.log(122);
  	$scope.data = { // date need to be updated also
      userName: $scope.userName,
      firstName: $scope.firstName,
      lastName: $scope.lastName,
      phone: $scope.phone,
      email: $scope.email,
      image: $scope.uploadme.src.split(',')[1],
      gender: $scope.gender,
      dob: $scope.DOB,
      password: $scope.password
    };

    $http.put('/CafeteriaApp.Backend/Requests/Register.php',$scope.data) 
    .then(function(response) {
       document.location = response.data;
    });

  };

  $scope.mylabel = angular.element("#mylabel");
  $scope.cancel = angular.element("#cancel");

  $scope.mylabel.on("click",function() {
    $scope.imageVisible = 1;
  });

  $scope.cancel.on("click",function() {
    $scope.imageVisible = 0;
  });

  $scope.cancel = function() {

    $scope.userName = $scope.firstName = $scope.lastName = $scope.phone = $scope.email
    = $scope.uploadme = $scope.gender = $scope.DOB = $scope.password = null;

  };

}]);