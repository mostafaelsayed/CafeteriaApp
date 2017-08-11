app.controller('favorites' , function($scope,$http) {

	

	$scope.getFavoriteItems=function () {
	
	$http.get('/CafeteriaApp.Backend/Requests/FavoriteItem.php')
	.then(function (response) {
      //console.log(response);
      $scope.favoriteItems = response.data;
    });

	}


	$scope.getFavoriteItems();



	$scope.deleteFavorItem=function (Id) {
	
	$http.delete('/CafeteriaApp.Backend/Requests/FavoriteItem.php?Id='+Id)
	.then(function (response) {
      //console.log(response);
      //$scope.favoriteItems = response.data;
    });

	}
});

