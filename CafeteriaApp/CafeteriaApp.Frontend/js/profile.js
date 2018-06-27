layoutApp.controller('profile', ['$scope', '$http', function($scope, $http) {
  $scope.imageUrl = '';
  $scope.csrf_token = document.getElementById('csrf_token').value;
  //$scope.i = 0;

  // $('#cropped').attr('src', $('#cropped').attr('src') + '?' + $scope.i);
  // $('#croppedLayout').attr('src', $('#croppedLayout').attr('src') + '?' + $scope.i);

  $scope.updateImage = function() {
    if ($scope.myform.$valid) {
      var data = {
        Image: $('#myimg').attr('src'),
        csrf_token: $scope.csrf_token,
        x1: $('#x1').val(),
        y1: $('#y1').val(),
        w: $('#w').val(),
        h: $('#h').val()
      };

      $('#myModal').hide();

      $http.post('/myapi/User/update/1', data)
      .then(function(response) {
        console.log(response);
        //$scope.i++;
        //$('#cropped').html($('#cropped').attr('src'));
        // $('#cropped').attr('src', $('#cropped').attr('src') + '?' + $scope.i);
        // $('#croppedLayout').attr('src', $('#croppedLayout').attr('src') + '?' + $scope.i);
        location.reload();
      });
    }
  };

  $scope.delete = function() {
    $http.delete('/myapi/User/f/1').then(function(response) {
      location.reload();
    });
  };
}]);