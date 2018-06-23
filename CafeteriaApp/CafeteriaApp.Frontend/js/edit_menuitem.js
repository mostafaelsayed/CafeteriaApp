var edit_menuitemApp = angular.module('edit_menuitem',['image', 'price']);

// controller for editing menuitem
edit_menuitemApp.controller('editMenuItem', ['$scope', '$http', function($scope, $http) {
  $scope.menuItemId = $.urlParam(1);
  $scope.arr = [ {id: 1,name: "Visible"} , {id: 0,name: "Invisible"} ];

  $scope.getMenuItem = function() {
    $http.get('/myapi/MenuItem/id/' + $scope.menuItemId)
    .then(function(response) {
      $scope.name = response.data.Name;
      $scope.price = response.data.Price;
      $scope.description = response.data.Description;
      $scope.imageUrl = response.data.Image;

      if (response.data.Visible == 1) {
        $scope.selectedElement = $scope.arr[0];
      }
      else {
        $scope.selectedElement = $scope.arr[1];
      }
    });
  };

  $scope.getMenuItem();

  $scope.editMenuItem = function() {
    if ($scope.myform.$valid) {
      var data = {
        Name: $scope.name,
        Price: $scope.price,
        Description: $scope.description,
        Id: $scope.menuItemId,
        Image: $('#image').attr('src'),
        Visible: $scope.selectedElement.id
      };

      if ($('#file').val() == '') {
        data.Image = '';
      }

      $http.put('/myapi/MenuItem',data)
      .then(function(response) {
        window.history.back();
      });
    }
  };

  $scope.updateOpenOrders = function() {
    $http.get('/myapi/UpdateOpenOrders')
    .then(function(response) {
      window.history.back();
    });
  };
}]);