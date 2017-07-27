var app = angular.module('myapp', ['angularModalService','ui.bootstrap']);
    app.config(['$locationProvider', function($locationProvider) {
      $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
      });
    }]);

    app.controller('ModalController', function($scope, close) {
  
 $scope.close = function(result) {
  close(result); // close, but give 500ms for bootstrap to animate
 };

});

// controller for getting categories from database
app.controller('getByCafeteriaId', function ($scope,$http,$location,ModalService) {

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
                //$scope.message = "You said " + result;
            });
        });
    };
   $scope.cafeteriaid = $location.search().id;
   //console.log($scope.cafeteriaid);
   $scope.gotocreatepage = function() {
     window.location.href = "/CafeteriaApp.Frontend/Areas/Admin/Category/Views/create.php?id="+$scope.cafeteriaid;
   }
   //$scope.createurl = "/CafeteriaApp.Frontend/Areas/Admin/Category/Views/create.php?id="+$scope.cafeteriaid;
   //console.log($scope.cafeteriaid);
   $scope.getcategories = function(){
    $http.get('/CafeteriaApp.Backend/Controllers/Category.php?Id='+$scope.cafeteriaid)
    .then(function (response) {
        $scope.categories = response.data;
        console.log(response);
    });
   }
    $scope.getcategories();
    $scope.goToEditCategoryPage = function(categoryid) {
      $scope.categoryid = $location.search().id;
      window.location.href = "/CafeteriaApp.Frontend/Areas/Admin/Category/Views/edit.php?id="+$scope.categoryid;
    }

     $scope.deleteCategory = function(categoryid){
      
    $scope.show();
     $scope.delete = function(){ 
      // var category = {
      //   id: categoryid
      // };
     $http.delete('/CafeteriaApp.Backend/Controllers/Category.php?categoryid='+categoryid)
     .then(function(response){
      console.log(response);
      $scope.getcategories();
     });
    };
  }
});

app.controller('editcafeteria',function($scope,$http,$location){
  $scope.Name = "";
  $scope.cafeteriaid = $location.search().id;


  $scope.editCafeteria = function() {
    var data = {
      Name: $scope.Name,
      Id: $scope.cafeteriaid
    };
    if ($scope.Name != "") {
  $http.put('/CafeteriaApp.Backend/Controllers/Cafeteria.php',data)
  .then(function(response){
    console.log(response);
    document.location = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/index.php";
   });
 };
  };
 });
// controller for adding category in the database
app.controller('addCategory',function($scope,$http,$location){
  $scope.Name = "";
  $scope.cafeteriaid = $location.search().id;
  //console.log($scope.cafeteriaid);
  $scope.addCategory = function () {
    var data = {
      Name: $scope.Name,
      CafeteriaId: $scope.cafeteriaid,
      action: "addCategory"
    };
  if ($scope.Name != "" && $scope.cafeteriaid != "") {
    $http.post('/CafeteriaApp.Backend/Controllers/Category.php',data)
    .then(function(response){
      //First function handles success
      document.location =  "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/edit.php?id="+$scope.cafeteriaid;
      console.log(response);
      //document.location="/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show.php";
    }, function(response) {
        //Second function handles error
        //console.log(response);
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
    //document.location = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/index.php";
   });
 };
  }
  });

