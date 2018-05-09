var phone_numberApp = angular.module('birth', []);

phone_numberApp.directive('checkBirth', function() {

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
      var regExp = /^\d{4}-[0-9]([0-9])?-\d{1,2}$/;
      
      ctrl.$parsers.unshift(function(val) {
        if (checkType(val, regExp) || val == undefined) {
          ctrl.$setValidity('checkBirth', true);
          
          return val;
        }
        else {
          ctrl.$setValidity('checkBirth', false);

          return undefined;
        }
      });
      ctrl.$formatters.unshift(function(val) {
        if (checkType(val, regExp) || val == undefined) {
          ctrl.$setValidity('checkBirth', true);
        }
        else {
            ctrl.$setValidity('checkBirth', false);
        }

        return val;
      });
    }
  }
})