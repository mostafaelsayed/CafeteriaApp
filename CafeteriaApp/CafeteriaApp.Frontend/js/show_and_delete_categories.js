var show_and_delete_categoriesApp = angular.module('show_and_delete_categoriesApp'
, ['modal', 'angularModalService', 'ui.bootstrap']);

show_and_delete_categoriesApp.controller('showAndDeleteCategories', ['$scope', '$http', 'ModalService',
function($scope, $http, ModalService) {
  $scope.getCategories = function() {

  $http.get('/myapi/Category')
    .then(function(response) {
      $scope.categories = response.data;
    });
  };

  $scope.getCategories();

  $scope.deleteCategory = function(category) {
    $scope.show();

    $scope.delete = function() {
      $http.delete('/myapi/Category/categoryId/' + category.Id)
      .then(function(response) {
        $scope.categories.splice($scope.categories.indexOf(category), 1);
      });
    };
  };

  $scope.show = function() {
    ModalService.showModal({
      templateUrl: '/templates/modal.html',
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