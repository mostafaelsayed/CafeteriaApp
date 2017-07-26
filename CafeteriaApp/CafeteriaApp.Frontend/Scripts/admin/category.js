var app = angular.module('myapp', []);
    app.config(['$locationProvider', function($locationProvider) {
      $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
      });
    }]);
// controller for getting categories from database
app.controller('getByCafeteriaId', function ($scope,$http,$location) {
   $scope.cafeteriaid = $location.search().id;
   $scope.gotocreatepage = function(){
     window.location.href = "/CafeteriaApp.Frontend/Areas/Admin/Category/Views/create.php?id="+$scope.cafeteriaid;
   }
   //$scope.createurl = "/CafeteriaApp.Frontend/Areas/Admin/Category/Views/create.php?id="+$scope.cafeteriaid;
   console.log($scope.cafeteriaid);
    $http.get('/CafeteriaApp.Backend/Controllers/Category.php?Id='+$scope.cafeteriaid)
    .then(function (response) {
        $scope.categories = response.data;
        console.log(response);
    });
});
// controller for adding category in the database
app.controller('addCategory',function($scope,$http,$location){
  $scope.Name = "";
  $scope.cafeteriaid = $location.search().id;
  console.log($scope.cafeteriaid);
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
      document.location =  "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show.php?id="+$scope.cafeteriaid;
      console.log(response);
      //document.location="/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show.php";
    }, function(response) {
        //Second function handles error
        //console.log(response);
    });
  }
  };
});
