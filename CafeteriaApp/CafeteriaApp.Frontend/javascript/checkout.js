
// controller for getting categories of a cafeteria from database


app.controller('OrderCheckout', function ($scope,$http,$location) {
  $scope.orderId = $location.search().orderId;
  $scope.selectedMethod = "";



  $scope.discardOrder = function(){
   $http.delete('/CafeteriaApp.Backend/Requests/Order.php?orderId='+$scope.orderId)
   .then(function(response) {
       //$scope.categories = response.data;
       //console.log(response);
    document.location =  "/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";

   });
  }


$scope.getUserInfo = function(){
   $http.get('/CafeteriaApp.Backend/Requests/Customer.php')
   .then(function(response) {
    console.log(response);
       $scope.customerInfo = response.data;
        $scope.recepientName= $scope.customerInfo.FirstName+' '+$scope.customerInfo.LastName;
        $scope.phone= $scope.customerInfo.PhoneNumber;

       //console.log(response);
    //document.location =  "/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";

   });
  }


$scope.getOrderInfo = function(){
   $http.get('/CafeteriaApp.Backend/Requests/Order.php')
   .then(function(response) {
       $scope.orderInfo = response.data;
        $scope.deliveryPlace=$scope.orderInfo.DeliveryPlace;
      $scope.total=$scope.orderInfo.Total;
       //console.log(response);
    //document.location =  "/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";

   });
  }
 
 $scope.getpaymentMethods = function(){
   $http.get('/CafeteriaApp.Backend/Requests/PaymentMethod.php')
   .then(function(response) {
       $scope.paymentMethods = response.data;
    //document.location =  "/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";

   });
  }


// $scope.closeOrder = function(){
//   if($scope.selectedMethod != undefined){
 
//  var data = {                   //date need to be updated also
//         orderId: $scope.orderId,
//         deliveryTimeId: $scope.deliveryTimeId,
//         deliveryPlace:$scope.deliveryPlace,
//         paymentMethodId:parseInt($scope.selectedMethod.Id),
//         paid: $scope.total
//       };
//   //update order info and close the state
//    $http.put('/CafeteriaApp.Backend/Requests/Order.php',data)
//    .then(function(response) {
//     //window.location = response.data;
//     //console.log(response);
//        //$scope.paymentMethods = response.data;
//     // document.location =  "/CafeteriaApp.Frontend/Areas/Customer/checkout2.php?orderId="+$scope.orderId+'&deliveryTimeDuration='+$scope.deliveryTimeDuration;

//    });
//   }

//   }


$scope.getOrderDeliveryTime = function(){
   $http.get('/CafeteriaApp.Backend/Requests/Order.php?orderId='+$scope.orderId)
   .then(function(response) {
       $scope.deliveryTimeId = response.data.Id;
      $scope.deliveryTimeDuration = response.data.Duration;
   });
  }
  

$scope.getUserInfo();
$scope.getOrderInfo();
$scope.getpaymentMethods();
$scope.getOrderDeliveryTime();

});
