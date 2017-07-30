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

app.controller('editcafeteria',function($scope,$http,$location){
  $scope.name = "";
  $scope.cafeteriaId = $location.search().id;

  $scope.editCafeteria = function() {
    var data = {
      Name: $scope.name,
      Id: $scope.cafeteriaId
    };
    if ($scope.name != "") {
      $http.put('/CafeteriaApp.Backend/Controllers/Cafeteria.php',data)
      .then(function(response){
        console.log(response);
        window.history.back();
    // document.location = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/index.php";
      });
    };
  };
});

// controller for showing and deleting categories

app.controller('showingAndDeletingCategories',function($scope,$http,$location) {
  $scope.cafeteriaId = $location.search().id;
  $scope.getCategories = function(){
    $http.get('/CafeteriaApp.Backend/Controllers/Category.php?Id='+$scope.cafeteriaId)
      .then(function (response) {
        $scope.categories = response.data;
        console.log(response);
      });
  }

  $scope.getCategories();

  $scope.deleteCategory = function(categoryId){
    $scope.show();
    $scope.delete = function(){
      $http.delete('/CafeteriaApp.Backend/Controllers/Category.php?categoryId='+categoryId)
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
