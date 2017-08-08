app.controller('ModalController',['$scope','close', function($scope, close) {
  $scope.close = function(result) {
    close(result,190);
  }
  $scope.closeModal = function() {
  	close(null);
  	//this.closed = true;
  }
}]);