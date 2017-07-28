var app = angular.module('myapp', ['angularModalService','ui.bootstrap']);

app.controller('ModalController', function($scope, close) {

 $scope.close = function(result) {
  close(result);
 };

});

// controller for getting cafeterias from database
app.controller('getcafeterias', function ($scope,$http,$location,ModalService) {
   $scope.show = function() {
        ModalService.showModal({
            templateUrl: 'modal.html',
            controller: "ModalController"
        }).then(function(modal) {
            modal.element.modal();
            modal.close.then(function(result)
             {
              if (result == "Yes"){
              $scope.delete();
            }
            });
        });
    };
    $scope.getcafeterias = function() {
      $http.get('/CafeteriaApp.Backend/Controllers/Cafeteria.php?action=getCafeterias')
    .then(function (response) {
        $scope.cafeterias = response.data;
        console.log(response);
    });
}

    $scope.editCafeteria = function(){
      $scope.cafeteriaid = $location.search().id;
      var data = {
      Name: $scope.Name,
      Id: $scope.cafeteriaid
    };
    if ($scope.Name != "") {
  $http.put('/CafeteriaApp.Backend/Controllers/Cafeteria.php',data)
  .then(function(response){
    console.log(response);
    window.history.back();
   });
 };
  };
  $scope.getcafeterias();
    $scope.goToEditCafeteriaPage = function(cafeteriaid){
      window.location.href = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/edit.php?id="+cafeteriaid;
    };
    $scope.deleteCafeteria = function(cafeteriaid) {
    $scope.show();
     $scope.delete = function() {
     $http.delete('/CafeteriaApp.Backend/Controllers/Cafeteria.php?cafeteriaid='+cafeteriaid)
     .then(function(response){
      console.log(response);
      $scope.getcafeterias();
     });
    };
  }
});

// controller for adding cafeteria in the database
app.controller('addcafeteria',function($scope,$http,$location){
  $scope.Name = "";
  $scope.addCafeteria = function () {
    var data = {
      Name: $scope.Name,
      action: "addcafeteria"
    };
  if ($scope.Name != "") {
    $http.post('/CafeteriaApp.Backend/Controllers/Cafeteria.php',data)
    .then(function(response){
      //First function handles success
      console.log(response);
      window.history.back();
    }, function(response) {
        //Second function handles error
    });
  }
  };

});
