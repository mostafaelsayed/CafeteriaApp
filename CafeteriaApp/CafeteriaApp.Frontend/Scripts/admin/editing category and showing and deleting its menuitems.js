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

app.controller('editCategory',function($scope,$http,$location){
  $scope.name = "";
  $scope.categoryId = $location.search().id;

  $scope.editCategory = function() {
    var data = {
      Name: $scope.name,
      Id: $scope.categoryId
    };
    if ($scope.name != "") {
      $http.put('/CafeteriaApp.Backend/Requests/Category.php',data)
      .then(function(response){
        console.log(response);
        window.history.back();
    // document.location = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/index.php";
      });
    };
  };
});


// controller for showing and deleting menuitems

app.controller('showingAndDeletingMenuItems',function($scope,$http,$location) {
  $scope.categoryId = $location.search().id;
  $scope.getMenuItems = function(){
    $http.get('/CafeteriaApp.Backend/Requests/MenuItem.php?Id='+$scope.categoryId)
    .then(function (response) {
      $scope.menuItems = response.data;
      console.log(response);
    });
  }

  $scope.getMenuItems();

  $scope.deleteMenuItem = function(menuItemId){
    $scope.show();
    $scope.delete = function(){
      $http.delete('/CafeteriaApp.Backend/Requests/MenuItem.php?menuItemId='+menuItemId)
      .then(function(response){
        console.log(response);
        $scope.getMenuItems();
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
