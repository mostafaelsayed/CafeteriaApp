// controller for getting and deleting cafeterias

app.controller('showAndDeleteUsers',['$scope','$http','ModalService', function ($scope,$http,ModalService) {
  $scope.show = function() {
    ModalService.showModal({
      templateUrl: 'modal.html',
      controller: "ModalController"
    }).then(function(modal) {
      modal.element.modal();
      modal.close.then(function(result){
        if (result == "Yes"){
          $scope.delete();
        }
      });
    });
  };

  $scope.getUsers = function() {
    $http.get('/CafeteriaApp.Backend/Requests/User.php')
    .then(function (response) {
      console.log(response);
      $scope.users = response.data;
    });
  }

  $scope.getUsers();

  $scope.deleteUser = function(user) {
    $scope.show();
    $scope.delete = function() {
     $http.delete('/CafeteriaApp.Backend/Requests/User.php?userId='+user.Id)
     .then(function(response) {
       $scope.getUsers();
     });
     if (user.RoleId == 1) {
      $http.delete('/CafeteriaApp.Backend/Requests/Admin.php?adminId='+user.Id)
      .then(function(response) {
      });
     }
     else if (user.RoleId == 2) {
      $http.delete('/CafeteriaApp.Backend/Requests/Cashier.php?cashierId='+user.Id)
      .then(function(response) {
      });
     }
     else if (user.RoleId == 3) {
      $http.delete('/CafeteriaApp.Backend/Requests/Cashier.php?customerId='+user.Id)
      .then(function(response) {
      });
     }
    };
  }
}]);