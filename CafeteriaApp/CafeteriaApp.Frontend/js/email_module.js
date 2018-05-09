var emailExistedApp = angular.module('email', []);

emailExistedApp.directive('checkEmail', ['$http', function($http) {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function(scope, elem, attr, ctrl) {
      ctrl.$parsers.unshift(function(val) {
        if (val != undefined) {
          var x = {
            Email: val
          };

          $http.post('../CafeteriaApp.Backend/Requests/User.php?flag=2', x).then(function(response) {
            if (response.data == true) {
              ctrl.$setValidity('emailExisted', false);

              return undefined;
            }
            else {
              ctrl.$setValidity('emailExisted', true);

              return val;
            }
          });

          return val;
        }
      });
      ctrl.$formatters.unshift(function(val) {
        if (val != undefined) {
          var x = {
            Email: val
          };

          $http.post('../CafeteriaApp.Backend/Requests/User.php?flag=2', x).then(function(response) {
            if (response.data == true) {
              ctrl.$setValidity('emailExisted', false);
            }
            else {
              ctrl.$setValidity('emailExisted', true);              
            }

            return val;
          });
        }
      });
    }
  }
}]);