var app = angular.module('myapp', ['angularModalService','ui.bootstrap','ngRoute']);

app.config(['$locationProvider',function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

app.config(['$routeProvider',function($routeProvider) {
  $routeProvider
  // add user
  .when("/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/1" , {
    templateUrl: "/CafeteriaApp.Frontend/Templates/Views/add_admin.php",
    controller: "addAdmin"
  })
  .when("/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/2", {
    templateUrl: "/CafeteriaApp.Frontend/Templates/Views/add_cashier.php",
    controller: "addCashier"
  })
  .when("/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php/3", {
    templateUrl: "/CafeteriaApp.Frontend/Templates/Views/add_customer.php",
    controller: "addCustomer"
  })
  
}]);

app.factory('userService',['$rootScope', function($rootScope) {

  var userServiceInstance = {};
  userServiceInstance.userData = {};

  $rootScope.$on('getUserData',function() {
    $rootScope.$broadcast('getYourUserData');
  });

  $rootScope.$on('hereIsMyUserData',function(event,data) {
    userServiceInstance.userData = data;
    $rootScope.$broadcast('userDataSent');
  });

  return userServiceInstance;
  
}]);

app.directive('fileDropzone', function() {
  return {
    restrict: 'A',
    scope: {
      file: '=',
      fileName: '='
    },
    link: function(scope, element, attrs) {
      var checkSize,
          isTypeValid,
          processDragOverOrEnter,
          validMimeTypes;
      
      processDragOverOrEnter = function (event) {
        if (event != null) {
          event.preventDefault();
        }
        event.dataTransfer.effectAllowed = 'copy';
        return false;
      };
      
      validMimeTypes = attrs.fileDropzone;
      
      checkSize = function(size) {
        var _ref;
        if (((_ref = attrs.maxFileSize) === (void 0) || _ref === '') || (size / 1024) / 1024 < attrs.maxFileSize) {
          return true;
        } else {
          alert("File must be smaller than " + attrs.maxFileSize + " MB");
          return false;
        }
      };

      isTypeValid = function(type) {
        if ((validMimeTypes === (void 0) || validMimeTypes === '') || validMimeTypes.indexOf(type) > -1) {
          return true;
        } else {
          alert("Invalid file type.  File must be one of following types " + validMimeTypes);
          return false;
        }
      };
      
      element.bind('dragover', processDragOverOrEnter);
      element.bind('dragenter', processDragOverOrEnter);

      return element.bind('drop', function(event) {
        var file, name, reader, size, type;
        if (event != null) {
          event.preventDefault();
        }
        reader = new FileReader();
        reader.onload = function(evt) {
          if (checkSize(size) && isTypeValid(type)) {
            return scope.$apply(function() {
              scope.file = evt.target.result;
              if (angular.isString(scope.fileName)) {
                return scope.fileName = name;
              }
            });
          }
        };
        file = event.dataTransfer.files[0];
        name = file.name;
        type = file.type;
        size = file.size;
        reader.readAsDataURL(file);
        return false;
      });
    }
  };
});

app.directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        scope.fileread = loadEvent.target.result;
                    });
                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);

function checkType(val,regExp) {
  if (regExp.test(val) && !isEmpty(val)) {
    return true;
  }
  else {
    return false;
  }
}

function isEmpty(val) {
  if (val == "") {
    return true;
  }
  else {
    return false;
  }
}

app.directive("numberCheck",function() {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function(scope,elem,attr,ctrl) {
      var regExp = /^\d{0,9}(\.\d{0,2}){0,1}$/; // regular expression for matching floating point numbers only
      ctrl.$parsers.unshift(function(val) {
        if (checkType(val,regExp)) {
          ctrl.$setValidity('numberCheck',true);
          ctrl.$setValidity('numberEmpty',true);
          return val;
        }
        else {
          if (isEmpty(val)) {
            ctrl.$setValidity('numberEmpty',false);
            ctrl.$setValidity('numberCheck',true);
            return undefined;
          }
          else {
            ctrl.$setValidity('numberCheck',false);
            ctrl.$setValidity('numberEmpty',true);
            return undefined;
          }
        }
      });
      ctrl.$formatters.unshift(function(val) {
        if (checkType(val,regExp)) {
          ctrl.$setValidity('numberEmpty',true);
          ctrl.$setValidity('numberCheck',true);
        }
        else {
          if (!isEmpty(val)) {
            ctrl.$setValidity('numberCheck',false);
            ctrl.$setValidity('numberEmpty',true);
          }
          else {
            ctrl.$setValidity('numberEmpty',false);
            ctrl.$setValidity('numberCheck',true);
          }
        }
        return val;
      });
    }
  }
});

app.directive('checkPhoneNumber',function(){
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function(scope,elem,attr,ctrl) {
      var regExp = /^\d{0,11}$/;
      ctrl.$parsers.unshift(function(val) {
        if (checkType(val,regExp)) {
          ctrl.$setValidity('checkPhoneNumber',true);
          ctrl.$setValidity('numberEmpty',true);
          return val;
        }
        else {
          if (isEmpty(val)) {
            ctrl.$setValidity('numberEmpty',false);
            ctrl.$setValidity('checkPhoneNumber',true);
            return undefined;
          }
          else {
            ctrl.$setValidity('checkPhoneNumber',false);
            ctrl.$setValidity('numberEmpty',true);
            return undefined;
          }
        }
      });
      ctrl.$formatters.unshift(function(val) {
        if (checkType(val,regExp)) {
          ctrl.$setValidity('numberEmpty',true);
          ctrl.$setValidity('checkPhoneNumber',true);
        }
        else {
          if (!isEmpty(val)) {
            ctrl.$setValidity('checkPhoneNumber',false);
            ctrl.$setValidity('numberEmpty',true);
          }
          else {
            ctrl.$setValidity('numberEmpty',false);
            ctrl.$setValidity('checkPhoneNumber',true);
          }
        }
        return val;
      });
    }
  }
})


app.factory('Order_Info' , ['$http','$rootScope',function($http,$rootScope)  {

  var order_info = {};
  //order_info.orderItems = [];
  //order_info.orderId = 0;

  order_info.getOrderItems = function(orderId) { // this is asyhnchronous
   // var q = $q.defer();
   //return  $http.get('/CafeteriaApp.Backend/Requests/OrderItem.php?orderId='+orderId)
   $http.get('/CafeteriaApp.Backend/Requests/OrderItem.php?orderId='+orderId).success(function(data) { 
      $rootScope.orderItems=data;

           }).error(function(){
               alert('something went wrong!!!');
           });
   // .then(function(response) {
        //console.log(response);
        //order_info.orderItems=response.data;
       // return response.data;
        // if (order_info.orderItems != null) {
        //   q.resolve(1);
        // }
        // else {
        //   q.reject(0);
        // }
    //});
    //return q.promise;
  };


// order_info.set=function (argument) {
//   order_info.orderItems =argument;
// };

// order_info.get=function () {
//   return order_info.orderItems ;
// };

  order_info.increaseQuantity = function(orderItem) {
    if(orderItem.OrderId != null) {
      var data = {
        Id: orderItem.Id,
        Quantity: parseInt(orderItem.Quantity)+1,
        Flag: true
      };
      $http.put('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {

        order_info.getOrderItems(orderItem.OrderId);
       
        //$rootScope.$broadcast('loadOrderItems',order_info.orderItems);
      });
    }
  }


  order_info.decreaseQuantity = function(orderItem) {
    console.log(orderItem);
    var data = {
      Id: orderItem.Id,
      Quantity: parseInt(orderItem.Quantity)-1,
      Flag: false
    };
    if (orderItem.Quantity > 1) {
      $http.put('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
          order_info.getOrderItems(orderItem.OrderId);
      });
    }
    else {
      order_info.deleteOrderItem(orderItem);
    }
  }


  order_info.deleteOrderItem = function(orderItem) {
    $http.delete('/CafeteriaApp.Backend/Requests/OrderItem.php?id='+orderItem.Id)
    .then(function(response) {
      order_info.getOrderItems(orderItem.OrderId);
    });
  }

  return order_info;

}]);