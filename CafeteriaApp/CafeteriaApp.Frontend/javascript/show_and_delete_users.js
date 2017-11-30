var show_and_delete_usersApp = angular.module('show_and_delete_users',['modal','angularModalService','ui.bootstrap'])

// controller for getting and deleting users
show_and_delete_usersApp.controller('showAndDeleteUsers',['$scope','$http','ModalService', function ($scope,$http,ModalService) {

  $scope.showModal = function(user) {

    ModalService.showModal({
      templateUrl: '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Templates/Views/modal.html',
      controller: "ModalController",
      inputs: {
        name: "user"
      }
      
    }).then(function(modal) {

      modal.element.modal();

      modal.close.then(function(result) {
        if (result == "Yes") {
          $scope.delete(user);
        }
      });

    });

  };

  $scope.getUsers = function() {

    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/User.php')
    .then(function(response) {
      console.log(response);
      $scope.users = response.data;
    });

  };

  $scope.getUsers();

  $scope.deleteUser = function(user) {
    $scope.showModal(user);
  };

  $scope.delete = function(user) {

   $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/User.php?userId='+parseInt(user.Id))
   .then(function(response) {
    console.log(response);
     $scope.users.splice($scope.users.indexOf(user),1);
   });

   if (user.RoleId == 1) {
    $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Admin.php?userId='+parseInt(user.Id))
    .then(function(response) {
    });
   }

   else if (user.RoleId == 3) {
    $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Cashier.php?userId='+parseInt(user.Id))
    .then(function(response) {
    });
   }

   else if (user.RoleId == 2) {
    $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Customer.php?userId='+parseInt(user.Id))
    .then(function(response) {
    });
   }

  };

}]);