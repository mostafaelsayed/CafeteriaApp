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

// controller for editing a cafeteria

app.controller('editCafeteria',function($scope,$http,$location){
  $scope.cafeteriaId = $location.search().id;

  $scope.getCafeteria = function(){
    $http.get('/CafeteriaApp.Backend/Requests/Cafeteria.php?id='+$scope.cafeteriaId)
    .then(function(response){
      $scope.name = response.data.Name;
      $scope.image = response.data.Image;
    });
  }

  $scope.getCafeteria();

  $scope.editCafeteria = function() {
    var data = {
      Name: $scope.name,
      Id: $scope.cafeteriaId
    };
    if ($scope.name != "") {
      $http.put('/CafeteriaApp.Backend/Requests/Cafeteria.php',data)
      .then(function(response){
        console.log(response);
        window.history.back();
      });
    };
  };
});

// controller for showing and deleting categories

app.controller('showingAndDeletingCategories',function($scope,$http,$location,ModalService) {
  $scope.cafeteriaId = $location.search().id;

  $scope.getCategories = function(){
    $http.get('/CafeteriaApp.Backend/Requests/Category.php?cafeteriaId='+$scope.cafeteriaId)
      .then(function (response) {
        $scope.categories = response.data;
        console.log(response);
      });
  }

  $scope.getCategories();

  $scope.deleteCategory = function(categoryId){
    $scope.show();
    $scope.delete = function(){
      $http.delete('/CafeteriaApp.Backend/Requests/Category.php?categoryId='+categoryId)
      .then(function(response){
        console.log(response);
        $scope.getCategories();
      });
    };
  }

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
});
