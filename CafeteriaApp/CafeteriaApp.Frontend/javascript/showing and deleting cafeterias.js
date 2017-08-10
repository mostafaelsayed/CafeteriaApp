// controller for getting and deleting cafeterias

app.controller('showingAndDeletingCafeterias',['$scope','$http','ModalService', function ($scope,$http,ModalService) {
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
      console.log(response);
      $scope.cafeterias = response.data;
    });
  }

  $scope.getCafeterias();

  $scope.deleteCafeteria = function(cafeteriaId) {
    $scope.show();
    $scope.delete = function() {
     $http.delete('/CafeteriaApp.Backend/Requests/Cafeteria.php?cafeteriaId='+cafeteriaId)
     .then(function(response){
       $scope.getCafeterias();
     });
    };
  }
}]);
