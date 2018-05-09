var checkPasswordApp = angular.module('password', []);

checkPasswordApp.directive('checkPassword', function() {

  function checkPassword(val, regExp) {
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
      var regExp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

      ctrl.$parsers.unshift(function(val) {
        if (checkPassword(val, regExp) || val == undefined) {
          ctrl.$setValidity('checkPassword', true);
          
          return val;
        }
        else {
          ctrl.$setValidity('checkPassword', false);

          return undefined;  
        }
      });
      ctrl.$formatters.unshift(function(val) {
        if (checkPassword(val, regExp) ||  val == undefined) {
          ctrl.$setValidity('checkPassword', true);
        }
        else {
          ctrl.$setValidity('checkPassword', false);
        }

        return val;
      });
    }
  }
})