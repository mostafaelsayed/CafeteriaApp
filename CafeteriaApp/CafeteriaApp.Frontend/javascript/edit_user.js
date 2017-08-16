app.controller('editUser',['$scope','$http','$location',function($scope,$http,$location) {

  $scope.userData = {};

  $http.get('/CafeteriaApp.Backend/Requests/User.php?userId='+$location.search().id)
  .then(function(response) {

    console.log(response);
    $scope.userData.userName = response.data.UserName;
    $scope.userData.firstName = response.data.FirstName;
    $scope.userData.lastName = response.data.LastName;
    $scope.userData.email = response.data.Email;
    $scope.userData.phoneNumber = response.data.PhoneNumber;
    $scope.userData.image = response.data.Image;
    $scope.userData.id = response.data.Id;
    $scope.userData.roleId = response.data.RoleId;
    
    $scope.$on('getYourData',function() {
      $scope.$emit('hereIsMyData',$scope.userData);
    });

  });

}]);