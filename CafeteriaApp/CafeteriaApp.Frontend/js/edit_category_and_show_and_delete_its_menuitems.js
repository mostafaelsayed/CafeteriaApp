var edit_category_and_show_and_delete_its_menuitemsApp = angular.module(
  'edit_category_and_show_and_delete_its_menuitems'
  , ['modal', 'angularModalService', 'ui.bootstrap', 'image']);

// controller for editing a category
edit_category_and_show_and_delete_its_menuitemsApp.controller('editCategory', ['$scope', '$http',
  function($scope, $http) {
  $scope.categoryId = $.urlParam(1);
  $scope.csrf_token = document.getElementById('csrf_token').value;

  $scope.getCategory = function() {
    $http.get('/myapi/Category/id/' + $scope.categoryId)
    .then(function(response) {
      $scope.name = response.data.Name;
      $scope.imageUrl = response.data.Image;
    });
  };

  $scope.getCategory();

  $scope.editCategory = function() {
    if ($scope.myform.$valid) {
      var data = {
        Name: $scope.name,
        Id: $scope.categoryId,
        Image: $('#image').attr('src'),
        csrf_token: $scope.csrf_token
      };

      if ($('#file').val() == '') {
        data.Image = '';
      }

      $http.put('/myapi/Category',data)
      .then(function(response) {
        window.history.back();
        //console.log(response);
      });
    }
  };
}]);

// controller for showing and deleting menuitems
edit_category_and_show_and_delete_its_menuitemsApp.controller('showAndDeleteMenuItems', ['$scope', '$http', 'ModalService',
  function($scope, $http, ModalService) {
    $scope.categoryId = $.urlParam(1);

    $scope.getMenuItems = function() {
      $http.get('/myapi/MenuItem/categoryId/' + $scope.categoryId)
      .then(function (response) {
        $scope.menuItems = response.data;
      });
    };

    $scope.getMenuItems();

    $scope.deleteMenuItem = function(menuItem) {
      $scope.show();

      $scope.delete = function() {
        $http.delete('/myapi/MenuItem/menuItemId/' + menuItem.Id)
        .then(function(response) {
          $scope.menuItems.splice($scope.menuItems.indexOf(menuItem),1);
        });

      };

    };

    $scope.show = function() {
      ModalService.showModal({
        templateUrl: '/templates/modal.html',
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