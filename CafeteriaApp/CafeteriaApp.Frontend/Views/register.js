var app = angular.module('myapp', []);

app.controller('Register', function($scope,$http){


$scope.registerfn=function () {

//if($scope.userName!=null && $scope.password!=null && $scope.firstName!=null && $scope.lastName!=null && $scope.email!=null&& $scope.phone!=null )
{
	var data = {                   //date need to be updated also
        userName: $scope.userName,
        firstName: $scope.firstName,
        lastName:$scope.lastName,
        phone:$scope.phone,
        email: $scope.email,
        image:$scope.image,
        gender:$scope.gender,
       dob:$scope.DOB,
		password:$scope.password

      };

 $http.post('/CafeteriaApp.Frontend/Views/register2.php',data) 
 .then(function(response) {
      console.log(response);
   });
   

}

}

});

