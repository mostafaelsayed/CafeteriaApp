app.controller('editMenuItem',['$scope','$http','$location',function($scope,$http,$location) {

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  $scope.menuItemId = $location.search().id;
  $scope.arr = [ {id: 1,name: "Visible"} , {id: 0,name: "Invisible"} ];

  $scope.getMenuItem = function() {

    $http.get('/CafeteriaApp.Backend/Requests/MenuItem.php?id='+$scope.menuItemId)
    .then(function(response) {

      console.log(response);
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

    var x = "";

    if ($scope.uploadme.src != '') {
      x = $scope.uploadme.src.split(',')[1];
    }

    else {
      x = $scope.imageUrl;
    }

    var data = {
      Name: $scope.name,
      Price: $scope.price,
      Description: $scope.description,
      Id: $scope.menuItemId,
      Image: x,
      Visible: $scope.selectedElement.id
    };

    if ($scope.name != "") {

      $http.put('/CafeteriaApp.Backend/Requests/MenuItem.php',data)
      .then(function(response) {

        console.log(response);
        window.history.back();

      });

    }

  };

  $scope.updateOpenOrders = function() {

    $http.get('/CafeteriaApp.Backend/Requests/UpdateOpenOrders.php')
    .then(function(response) {
       window.history.back();
    });

  };

}]);