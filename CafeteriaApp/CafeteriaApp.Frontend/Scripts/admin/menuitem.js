var app = angular.module('myapp', ['angularModalService','ui.bootstrap']);
    app.config(['$locationProvider', function($locationProvider) {
      $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
      });
    }]);

    app.controller('ModalController', function($scope, close) {

 $scope.close = function(result) {
  close(result);
 };

});

// controller for getting categories from database
app.controller('getByCategoryId', function ($scope,$http,$location,ModalService) {

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
   $scope.categoryid = $location.search().id;

   $scope.getMenuItems = function(){
    $http.get('/CafeteriaApp.Backend/Controllers/MenuItem.php?Id='+$scope.categoryid)
    .then(function (response) {
        $scope.menuItems = response.data;
        console.log(response);
    });
   }
    $scope.getMenuItems();

     $scope.deleteMenuItem = function(menuItemId){

    $scope.show();
     $scope.delete = function(){
     $http.delete('/CafeteriaApp.Backend/Controllers/MenuItem.php?menuitemid='+menuItemId)
     .then(function(response){
      console.log(response);
      $scope.getMenuItems();
     });
    };
  }
});

app.controller('editMenuItem',function($scope,$http,$location){
  $scope.Name = "";
  $scope.categoryid = $location.search().id;


  $scope.editMenuItem = function() {
    var data = {
      Name: $scope.Name,
      Price: $scope.Price,
      Description: $scope.Description,
      Id: $scope.categoryid
    };
    if ($scope.Name != "") {
  $http.put('/CafeteriaApp.Backend/Controllers/MenuItem.php',data)
  .then(function(response){
    console.log(response);
    window.history().back();
    // document.location = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/index.php";
   });
 };
  };
 });
// controller for adding category in the database
app.controller('addMenuItem',function($scope,$http,$location){
  $scope.Name = "";
  $scope.Price = "";
  $scope.Description = "";
  $scope.categoryid = $location.search().id;
  //console.log($scope.cafeteriaid);
  $scope.addMenuItem = function () {
    var data = {
      Name: $scope.Name,
      Price: $scope.Price,
      Description: $scope.Description,
      Id: $scope.categoryid,
      action: "addMenuItem"
      //action: "addCategory"
    };
  if ($scope.Name != "" && $scope.categoryid != "" && $scope.Price != "" && $scope.Description != "") {
    $http.post('/CafeteriaApp.Backend/Controllers/MenuItem.php',data)
    .then(function(response){
      //First function handles success
      // document.location =  "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/edit.php?id="+$scope.cafeteriaid;
      console.log(response);
      window.history.back();
    }, function(response) {
        //Second function handles error
    });
  }
  };
});

  app.controller('editcategory',function($scope,$http,$location) {
    $scope.Name = "";
  $scope.categoryid = $location.search().id;


  $scope.editCategory = function() {
    var data = {
      Name: $scope.Name,
      Id: $scope.categoryid
    };
    if ($scope.Name != "") {
  $http.put('/CafeteriaApp.Backend/Controllers/Category.php',data)
  .then(function(response){
    console.log(response);
    window.history.back();
   });
 };
  }
  });
