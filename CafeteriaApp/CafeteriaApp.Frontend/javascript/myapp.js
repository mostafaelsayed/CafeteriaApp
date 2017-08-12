var app = angular.module('myapp', ['angularModalService','ui.bootstrap']);

app.config(['$locationProvider',function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
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

app.directive("numberCheck",function() {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function(scope,elem,attr,ctrl) {
      var regExp = /^\d{0,9}(\.\d{0,2}){0,1}$/; // regular expression for matching floating point numbers only
      function checkType(val) {
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
      ctrl.$parsers.unshift(function(val) {
        if (checkType(val)) {
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
        if (checkType(val)) {
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


// app.service('Languages' , function ($http) {

//    this.getLanguages = function () {
//   $http.get('/CafeteriaApp.Backend/Requests/Languages.php')
// .then(function(response) {

//  return response.data;
// });


//     }
// });