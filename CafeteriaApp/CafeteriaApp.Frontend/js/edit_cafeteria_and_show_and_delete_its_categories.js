var edit_cafeteria_and_show_and_delete_its_categoriesApp = angular.module('edit_cafeteria_and_show_and_delete_its_categories'
,['location_provider','modal','angularModalService','ui.bootstrap','image']);

edit_cafeteria_and_show_and_delete_its_categoriesApp.controller('editCafeteria',['$scope','$http','$location',function($scope,$http,$location) {

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';
  $scope.cafeteriaId = $location.search().id;

  $scope.getCafeteria = function() {

    $http.get('../../CafeteriaApp.Backend/Requests/Cafeteria.php?id=' + $scope.cafeteriaId)
    .then(function(response) {
      $scope.name = response.data.Name;
      $scope.imageUrl = response.data.Image;
    });

  };

  $scope.getCafeteria();

  $scope.editCafeteria = function() {

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
        Id: $scope.cafeteriaId,
        Image: x
      };   

      $http.put('../../CafeteriaApp.Backend/Requests/Cafeteria.php',data)
      .then(function(response) {
        window.history.back();
      });     

    }

  };

}]);

// controller for showing and deleting categories

edit_cafeteria_and_show_and_delete_its_categoriesApp.controller('showAndDeleteCategories',['$scope','$http','$location','ModalService',function($scope,$http,$location,ModalService) {

  $scope.cafeteriaId = $location.search().id;

  $scope.getCategories = function() {

  $http.get('../../CafeteriaApp.Backend/Requests/Category.php?cafeteriaId='+$scope.cafeteriaId)
    .then(function(response) {
      $scope.categories = response.data;
    });

  };

  $scope.getCategories();

  $scope.deleteCategory = function(category) {

    $scope.show();

    $scope.delete = function() {

      $http.delete('../../CafeteriaApp.Backend/Requests/Category.php?categoryId=' + category.Id)
      .then(function(response) {
        $scope.categories.splice($scope.categories.indexOf(category),1);
      });

    };

  };

  $scope.show = function() {

    ModalService.showModal({
      templateUrl: '../../CafeteriaApp.Frontend/Templates/Views/modal.html',
      controller: "ModalController",
      inputs: {
        name: "category"
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