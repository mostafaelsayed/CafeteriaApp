// controller for editing a cafeteria

app.controller('editCafeteria',['$scope','$http','$location',function($scope,$http,$location){

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';
  $scope.cafeteriaId = $location.search().id;

  $scope.getCafeteria = function(){
    $http.get('/CafeteriaApp.Backend/Requests/Cafeteria.php?id='+$scope.cafeteriaId)
    .then(function(response){
      $scope.name = response.data.Name;
      $scope.imageUrl = response.data.Image;
    });
  }

  $scope.getCafeteria();

  $scope.editCafeteria = function() {
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
    if ($scope.name != "") {
      $http.put('/CafeteriaApp.Backend/Requests/Cafeteria.php',data)
      .then(function(response){
        console.log(response);
        window.history.back();
      });
    };
  };
}]);

// controller for showing and deleting categories

app.controller('showAndDeleteCategories',['$scope','$http','$location','ModalService',function($scope,$http,$location,ModalService) {
  $scope.cafeteriaId = $location.search().id;

  $scope.getCategories = function(){
    $http.get('/CafeteriaApp.Backend/Requests/Category.php?cafeteriaId='+$scope.cafeteriaId)
      .then(function (response) {
        $scope.categories = response.data;
      });
  }

  $scope.getCategories();

  $scope.deleteCategory = function(categoryId){
    $scope.show();
    $scope.delete = function(){
      $http.delete('/CafeteriaApp.Backend/Requests/Category.php?categoryId='+categoryId)
      .then(function(response){
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
}]);