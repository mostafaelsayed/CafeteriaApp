var registerFormApp = angular.module('registerFormValidation', []);

registerFormApp.directive('check', ['$http', function($http) {
  function checkType(val, regExp) {
    if ( regExp.test(val) ) {
      return true;
    }
    else {
      return false;
    }
  }

  return {
    restrict: 'A',
    require: 'ngModel',
    link: function(scope, elem, attr, ctrl) {
      ctrl.$parsers.unshift(function(val) {
        if (val != undefined) {
          if (attr.name == 'email') {
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
          else if (attr.name == 'password') {
            var regExp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

            if (checkType(val, regExp) || val == undefined) {
              ctrl.$setValidity('checkPassword', true);
              
              return val;
            }
            else {
              ctrl.$setValidity('checkPassword', false);

              return undefined;  
            }
          }
          else if (attr.name == 'phone') {
            var regExp = /^01\d{9}$/;

            if (checkType(val, regExp) || val == undefined) {
              ctrl.$setValidity('checkPhoneNumber', true);
              
              return val;
            }
            else {
              ctrl.$setValidity('checkPhoneNumber', false);

              return undefined;
            }
          }
          else if (attr.name == 'DOB') {
            var regExp = /^\d{4}-[0-9]([0-9])?-\d{1,2}$/;

            if (checkType(val, regExp) || val == undefined) {
              ctrl.$setValidity('checkBirth', true);
              
              return val;
            }
            else {
              ctrl.$setValidity('checkBirth', false);

              return undefined;
            }
          }
        }
      });
      ctrl.$formatters.unshift(function(val) {
        if (val != undefined) {
          if (attr.name == 'email') {
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
          else if (attr.name == 'password') {
            var regExp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

            if (checkType(val, regExp) ||  val == undefined) {
              ctrl.$setValidity('checkPassword', true);
            }
            else {
              ctrl.$setValidity('checkPassword', false);
            }

            // return val;
          }
          else if (attr.name == 'phone') {
            var regExp = /^01\d{9}$/;

            if (checkType(val, regExp) || val == undefined) {
              ctrl.$setValidity('checkPhoneNumber', true);
            }
            else {
              ctrl.$setValidity('checkPhoneNumber', false);
            }

            // return val;
          }
          else if (attr.name == 'DOB') {
            var regExp = /^\d{4}-[0-9]([0-9])?-\d{1,2}$/;

            if (checkType(val, regExp) || val == undefined) {
              ctrl.$setValidity('checkBirth', true);
            }
            else {
              ctrl.$setValidity('checkBirth', false);
            }

            // return val;
          }

          return val;
        }
      });
    }
  }
}]);