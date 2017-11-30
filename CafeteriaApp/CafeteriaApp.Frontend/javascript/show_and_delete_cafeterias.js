var show_and_delete_cafeteriasApp = angular.module('show_and_delete_cafeterias',['modal','angularModalService','ui.bootstrap']);

show_and_delete_cafeteriasApp.controller('showAndDeleteCafeterias',['$scope','$http','ModalService', function ($scope,$http,ModalService) {

  $scope.show = function() {

    ModalService.showModal({
      templateUrl: '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Templates/Views/modal.html',
      controller: "ModalController",
      inputs: {
        name: "cafeteria"
      }
      
    }).then(function(modal) {
      modal.element.modal();
      modal.close.then(function(result) {
        if (result == "Yes") {
          $scope.delete();
        }
      });

    });

  };

  $scope.getCafeterias = function() {

    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Cafeteria.php')
    .then(function (response) {
      $scope.cafeterias = response.data;
    });

  };

  $scope.getCafeterias();

  $scope.deleteCafeteria = function(cafeteria) {

    $scope.show();

    $scope.delete = function() {
     $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Cafeteria.php?cafeteriaId='+cafeteria.Id)
     .then(function(response) {
       $scope.cafeterias.splice($scope.cafeterias.indexOf(cafeteria),1);
     });

    };

  };

}]);