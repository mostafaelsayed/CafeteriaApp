var app = angular.module('myapp', []);

app.controller('Register', function($scope,$http){


$scope.checkExistingMailAndUserName=function () {

var data = {                   //date need to be updated also
        userName: $scope.userName,
        email: $scope.email
      };

       $http.post('/CafeteriaApp.Backend/Requests/Register.php',data) 
    .then(function(response) {

     // document.getElemntById('emailConfirm').innerHtml= response.data;
    
    if(response.data==="")
    {
      return true;
    }
    else{
      alertify.error( response.data);
      return false;
    }
   });
    
}


$scope.registerfn=function () {
if($scope.checkExistingMailAndUserName()){
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

 $http.put('/CafeteriaApp.Backend/Requests/Register.php',data) 
 .then(function(response) {
      console.log(response.data);
     document.location=response.data;
   });
   

}
}

}




});

