app.controller('addAdmin',['$scope','$http',function($scope,$http){
	$http.post('/CafeteriaApp.Backend/Requests/Admin.php',data)
	.then(function(response) {
		console.log(response);
		document.location = "/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php";
	});
}]);