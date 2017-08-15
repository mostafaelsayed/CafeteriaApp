<!DOCTYPE html>
<html>
<head>
  <script src="/CafeteriaApp.Frontend/javascript/angular.min.js"></script>

	<title></title>
</head>
<body ng-app= "myapp">
<div ng-controller ="Ctrl" >
<select 
    ng-model="selectedOption" 
    ng-options="option.Name for option in options"   ng-init=""  ng-change="getStuff(data.selectedOption)">
</select>
</div>




</body>
</html>

<script type="text/javascript">
	
var app = angular.module('myapp', []);

var langs=[];

app.controller('Ctrl',function function_name($scope,$http) {
  
  $scope.getLanguages=function () {

$http.get('/CafeteriaApp.Backend/Requests/Languages.php')
.then(function(response) {
 
  $scope.options = response.data;
$scope.selectedOption=$scope.options[1];
  //langs= response.data;
  //console.log(langs);
 // console.log($scope.options );
},function(response) {

    console.log( "Something went wrong");
}
);
}
		$scope.getLanguages();
		//console.log(langs);
    //  $scope.selectedOption = $scope.options[1].Id;
});
	

</script>