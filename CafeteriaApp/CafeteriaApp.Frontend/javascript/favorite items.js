app.controller('favorites' , function($scope,$http) {

	$scope.getFavoriteItems=function () {
	
	$http.get('/CafeteriaApp.Backend/Requests/FavoriteItem.php')
	.then(function (response) {
      //console.log(response);
      $scope.favoriteItems = response.data;
    });

	}


	$scope.getFavoriteItems();



	$scope.deleteFavorItem=function (menuItemId,index) {
	
	$http.delete('/CafeteriaApp.Backend/Requests/FavoriteItem.php?MenuItemId='+menuItemId)
	.then(function (response) {
      //console.log(response);
      $scope.favoriteItems.splice( index ,1) ;
    });

	}
});

