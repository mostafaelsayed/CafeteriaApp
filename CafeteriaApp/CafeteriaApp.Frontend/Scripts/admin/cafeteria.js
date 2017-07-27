//function UserViewModel() {
//    var self = this;
//    self.users = ko.observableArray();


//    self.showError = function (jqXHR) {

//        self.result(jqXHR.status + ': ' + jqXHR.statusText);

//        var response = jqXHR.responseJSON;
//        if (response) {
//            if (response.Message) self.errors.push(response.Message);
//            if (response.ModelState) {
//                var modelState = response.ModelState;
//                for (var prop in modelState) {
//                    if (modelState.hasOwnProperty(prop)) {
//                        var msgArr = modelState[prop]; // expect array here
//                        if (msgArr.length) {
//                            for (var i = 0; i < msgArr.length; ++i) self.errors.push(msgArr[i]);
//                        }
//                    }
//                }
//            }
//            if (response.error) self.errors.push(response.error);
//            if (response.error_description) self.errors.push(response.error_description);
//        }
//    }


//    self.getAllUsers = function () {
//        $.ajax({
//            type: 'Get',
//            url: '/api/user/Get',
//            contentType: 'application/json; charset=utf-8'
//        }).done(function (result) {
//            self.users(result.users);
//            console.log(self.users());
//        }).fail(function () { self.showError() });
//    }
//    self.getAllUsers();
//}
var app = angular.module('myapp', ['angularModalService','ui.bootstrap']);



// app.config(function ($routeProvider) {
//             $routeProvider.when('/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show.php/:id', {
//                 //templateUrl: '/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show.php',
//                 //controller: 'loginController'
//             //}).when('/student/:username', {
//               //  templateUrl: '/student.html',
//                 //controller: 'studentController'
//             }).otherwise({
//                 //redirectTo: "/"
//             });
//           });


app.controller('ModalController', function($scope, close) {
  
 $scope.close = function(result) {
  close(result); // close, but give 500ms for bootstrap to animate
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
                //$scope.message = "You said " + result;
            });
        });
    };
    $scope.getcafeterias = function() {
      $http.get('/CafeteriaApp.Backend/Controllers/Cafeteria.php?action=getCafeterias')
    .then(function (response) {
        $scope.cafeterias = response.data;
        console.log(response);
    });
  };
  $scope.getcafeterias();
    $scope.goToEditCafeteriaPage = function(cafeteriaid){
      //$location.path('/show.php/'+cafeteriaid)

      window.location.href = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/edit.php?id="+cafeteriaid;
      //document.loction = "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show.php/"+cafeteriaid;
    };
    $scope.deleteCafeteria = function(cafeteriaid){
      
    $scope.show();
     $scope.delete = function(){ 
      var cafeteria = {
        id: cafeteriaid
      };
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
      document.location =  "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/index.php";
      //$location.path("/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/index.php");
    }, function(response) {
        //Second function handles error
        //console.log(response);
    });
  }
  };

});
