<?php require_once("CafeteriaApp.Backend/Controllers/Notification.php"); 
require_once("CafeteriaApp.Backend/connection.php");

// if(!empty($_SESSION["notifications"]))
      //     { 
      //         $ul="<ul style='color:blue;'>";
      //       foreach ($_SESSION["notifications"] as  $value) {
      //          $ul.= "<li>".$value."</li>";
      //       }
      //     }
      //     $ul.="</ul>";
      // echo $ul;
      print_r(getNotificationByUserId($conn , 3 )) ;// if not founds
//header("location:try.php");
 ?>
<!DOCTYPE html>
<html>
<head>
  <script src="/CafeteriaApp.Frontend/javascript/angular.min.js"></script>

	<title></title>
</head>
<body ng-app= "myapp">
<div ng-controller ="Ctrl" >
<div>
<select 
    ng-model="selectedOption" 
    ng-options="option.Name for option in options"   ng-init=""  ng-change="getStuff(data.selectedOption)">
</select>
</div>
<div>
  <textarea ng-model="ddd"></textarea>
</div>
</div>
</body>
</html>

<script type="text/javascript">
	
var app = angular.module('myapp', []);

var langs=[];

app.controller('Ctrl',function($scope,$http) {

  $scope.getLanguages=function () {
//$scope.selectedOption ="";
$http.get('/CafeteriaApp.Backend/Requests/Languages.php')
.then(function(response) {
 $scope.options = response.data;
 $scope.func();
   $scope.ddd="dddddddddd";
  // console.log($scope.selectedOption);

  //langs= response.data;
  //console.log(langs);
 // console.log($scope.options );
// },function(response) {

//     console.log( "Something went wrong");
  });
}
		

$scope.func = function() {
  $scope.selectedOption = $scope.options[1];

}
 var dd="sss"+3;
 console.log(dd);
    $scope.getLanguages();
		//console.log($scope.options);
     // $scope.selectedOption = $scope.options[1];
});
	

</script>

<?php  ?> 