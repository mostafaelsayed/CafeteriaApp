var app = angular.module('myapp', []);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

// controller for adding menuitem to the database

app.controller('addCafeteria',function($scope,$http,$location){

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';

  //$scope.name = "";
  
  // $scope.addMenuItem = function () {
  //   var data = {
  //     Name: $scope.name,
  //     Price: $scope.price,
  //     Description: $scope.description,
  //     CategoryId: $scope.categoryId,
  //     Image: $scope.uploadme.src.split(',')[1]
  //     //action: "addMenuItem"
  //   };
  //   if ($scope.name != "" && $scope.categoryId != "") {
  //     $http.post('/CafeteriaApp.Backend/Requests/MenuItem.php',data)
  //     .then(function(response){
  //       console.log(response);
  //       //First function handles success
  //       window.history.back();
  //       // document.location =  "/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/edit.php?id="+$scope.cafeteriaid;
  //     }, function(response) {
  //       //Second function handles error
  //     });
  //   }
  // };
});

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
        //reader.readAsBinaryString(file);
        reader.readAsDataURL(file);
        return false;
      });
    }
  };
})


.directive("fileread", [function () {
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