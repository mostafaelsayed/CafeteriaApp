var phone_numberApp = angular.module('phone_number', []);

phone_numberApp.directive('checkPhoneNumber', function() {

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
      var regExp = /^01\d{9}$/;
      
      ctrl.$parsers.unshift(function(val) {
        if (checkType(val, regExp) || val == undefined) {
          ctrl.$setValidity('checkPhoneNumber', true);
          
          return val;
        }
        else {
          ctrl.$setValidity('checkPhoneNumber', false);

          return undefined;
        }
      });
      ctrl.$formatters.unshift(function(val) {
        if (checkType(val, regExp) || val == undefined) {
          ctrl.$setValidity('checkPhoneNumber', true);
        }
        else {
            ctrl.$setValidity('checkPhoneNumber', false);
        }

        return val;
      });
    }
  }
})