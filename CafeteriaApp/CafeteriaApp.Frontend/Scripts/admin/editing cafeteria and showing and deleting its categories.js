var app = angular.module('myapp', ['angularModalService','ui.bootstrap']);

app.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}]);

app.controller('ModalController', function($scope, close) {
  $scope.close = function(result) {
    close(result);
  };
});

// controller for editing a cafeteria

app.controller('editCafeteria',function($scope,$http,$location){

  $scope.image = null;
  $scope.imageFileName = '';
  
  $scope.uploadme = {};
  $scope.uploadme.src = '';
  $scope.cafeteriaId = $location.search().id;

  $scope.getCafeteria = function(){
    $http.get('/CafeteriaApp.Backend/Requests/Cafeteria.php?id='+$scope.cafeteriaId)
    .then(function(response){
      console.log(response);
      $scope.name = response.data.Name;
      $scope.imageUrl = response.data.Image;
    });
  }

  $scope.getCafeteria();

  $scope.editCafeteria = function() {
    var x = "";
    if ($scope.uploadme.src != '') {
      x = $scope.uploadme.src.split(',')[1];
    }
    else {
      x = $scope.imageUrl;
    }
    var data = {
      Name: $scope.name,
      Id: $scope.cafeteriaId,
      Image: x
    };
    if ($scope.name != "") {
      $http.put('/CafeteriaApp.Backend/Requests/Cafeteria.php',data)
      .then(function(response){
        console.log(response);
        window.history.back();
      });
    };
  };
});

// controller for showing and deleting categories

app.controller('showingAndDeletingCategories',function($scope,$http,$location,ModalService) {
  $scope.cafeteriaId = $location.search().id;

  $scope.getCategories = function(){
    //console.log(1);
    $http.get('/CafeteriaApp.Backend/Requests/Category.php?cafeteriaId='+$scope.cafeteriaId)
      .then(function (response) {
        $scope.categories = response.data;
        console.log(response);
      });
  }

  $scope.getCategories();

  $scope.deleteCategory = function(categoryId){
    $scope.show();
    $scope.delete = function(){
      $http.delete('/CafeteriaApp.Backend/Requests/Category.php?categoryId='+categoryId)
      .then(function(response){
        console.log(response);
        $scope.getCategories();
      });
    };
  }

  $scope.show = function() {
    ModalService.showModal({
      templateUrl: 'modal.html',
      controller: "ModalController"
    }).then(function(modal) {
      modal.element.modal();
      modal.close.then(function(result){
          if (result == "Yes"){
            $scope.delete();
          }
      });
    });
  };
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