var app = angular.module('myapp', ['angularModalService','ui.bootstrap']);
app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

app.controller('ModalController', function($scope, close) {
  $scope.close = function(result) {
    close(result);
  };
});

// controller for getting and deleting cafeterias
app.controller('showingAndDeletingCafeterias', function ($scope,$http,$location,ModalService) {
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

  $scope.getCafeterias = function() {
    $http.get('/CafeteriaApp.Backend/Requests/Cafeteria.php?action=getCafeterias')
    .then(function (response) {
      $scope.cafeterias = response.data;
      console.log(response);
    });
  }

  $scope.getCafeterias();

  $scope.deleteCafeteria = function(cafeteriaId) {
    $scope.show();
    $scope.delete = function() {
     $http.delete('/CafeteriaApp.Backend/Requests/Cafeteria.php?cafeteriaId='+cafeteriaId)
     .then(function(response){
       console.log(response);
       $scope.getCafeterias();
     });
    };
  }
});
