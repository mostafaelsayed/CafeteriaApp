var edit_category_and_show_and_delete_its_menuitemsApp = angular.module('edit_category_and_show_and_delete_its_menuitems'
,['location_provider','modal','angularModalService','ui.bootstrap','image']);

// controller for editing a category
edit_category_and_show_and_delete_its_menuitemsApp.controller('editCategory',['$scope','$http','$location',function($scope,$http,$location) {

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';
  $scope.categoryId = $location.search().id;

  $scope.getCategory = function() {

    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Category.php?id=' + $scope.categoryId)
    .then(function(response) {
      $scope.name = response.data.Name;
      $scope.imageUrl = response.data.Image;
    });

  };

  $scope.getCategory();

  $scope.editCategory = function() {

    if ($scope.myform.$valid) {

      var x = "";

      if ($scope.uploadme.src != '') {
        x = $scope.uploadme.src.split(',')[1];
      }

      else {
        x = $scope.imageUrl;
      }

      var data = {
        Name: $scope.name,
        Id: $scope.categoryId,
        Image: x
      };

      $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Category.php',data)
      .then(function(response) {
        window.history.back();
      });

    }

  };

}]);

// controller for showing and deleting menuitems
edit_category_and_show_and_delete_its_menuitemsApp.controller('showAndDeleteMenuItems',['$scope','$http','$location','ModalService',function($scope,$http,$location,ModalService) {

  $scope.categoryId = $location.search().id;

  $scope.getMenuItems = function() {

    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/MenuItem.php?categoryId='+$scope.categoryId)
    .then(function (response) {
      $scope.menuItems = response.data;
    });

  };

  $scope.getMenuItems();

  $scope.deleteMenuItem = function(menuItem) {

    $scope.show();

    $scope.delete = function() {
      
      $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/MenuItem.php?menuItemId='+menuItem.Id)
      .then(function(response) {
        $scope.menuItems.splice($scope.menuItems.indexOf(menuItem),1);
      });

    };

  };

  $scope.show = function() {
    ModalService.showModal({
      templateUrl: '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Templates/Views/modal.html',
      controller: "ModalController",
      inputs: {
        name: "menuitem"
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
}]);