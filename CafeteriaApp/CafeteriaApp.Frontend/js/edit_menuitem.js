var edit_menuitemApp = angular.module('edit_menuitem',['image', 'price']);

// controller for editing menuitem
edit_menuitemApp.controller('editMenuItem', ['$scope', '$http', function($scope, $http) {

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  $scope.menuItemId = $.urlParam('id');
  $scope.arr = [ {id: 1,name: "Visible"} , {id: 0,name: "Invisible"} ];

  $scope.getMenuItem = function() {

    $http.get('../../../CafeteriaApp.Backend/Requests/MenuItem.php?id=' + $scope.menuItemId)
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

      var x = "";

      if ($scope.uploadme.src != '') {
        x = $scope.uploadme.src.split(',')[1];
      }

      else {
        x = '';
      }

      var data = {
        Name: $scope.name,
        Price: $scope.price,
        Description: $scope.description,
        Id: $scope.menuItemId,
        Image: x,
        Visible: $scope.selectedElement.id
      };

      $http.put('../../../CafeteriaApp.Backend/Requests/MenuItem.php',data)
      .then(function(response) {
        window.history.back();
      });

    }

  };

  $scope.updateOpenOrders = function() {

    $http.get('../../../CafeteriaApp.Backend/Requests/UpdateOpenOrders.php')
    .then(function(response) {
      window.history.back();
    });

  };

}]);