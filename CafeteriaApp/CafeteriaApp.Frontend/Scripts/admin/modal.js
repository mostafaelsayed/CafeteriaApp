app.controller('ModalController',['$scope','close', function($scope, close) {
  $scope.close = function(result) {
    close(result);
  };
}]);