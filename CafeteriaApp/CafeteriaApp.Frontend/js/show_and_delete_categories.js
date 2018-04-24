var show_and_delete_categoriesApp = angular.module('show_and_delete_categoriesApp'
, ['modal', 'angularModalService', 'ui.bootstrap']);

show_and_delete_categoriesApp.controller('showAndDeleteCategories', ['$scope', '$http', 'ModalService',
  function($scope, $http, ModalService) {

  $scope.getCategories = function() {

  $http.get('../../../CafeteriaApp.Backend/Requests/Category.php')
    .then(function(response) {
      $scope.categories = response.data;
    });

  };

  $scope.getCategories();

  $scope.deleteCategory = function(category) {

    $scope.show();

    $scope.delete = function() {

      $http.delete('../../../CafeteriaApp.Backend/Requests/Category.php?categoryId=' + category.Id)
      .then(function(response) {
        $scope.categories.splice($scope.categories.indexOf(category), 1);
      });

    };

  };

  $scope.show = function() {

    ModalService.showModal({
      templateUrl: '../../../CafeteriaApp.Frontend/Templates/Views/modal.html',
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