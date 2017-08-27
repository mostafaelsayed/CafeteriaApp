// controller for order checkout

app.controller('OrderCheckout',['$scope','$http','$location',function ($scope,$http,$location) {

  $scope.orderId = $location.search().orderId;
  $scope.selectedMethod = "";
  $scope.categoryId = $location.search().categoryId;
  $scope.orderTypes = [{id: 0,name: "Take Away"},{id: 1,name: "Delivery"}];
  

  $scope.discardOrder = function() {
   $http.delete('/CafeteriaApp.Backend/Requests/Order.php?orderId='+$scope.orderId)
   .then(function(response) {
      document.location =  "/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";
   });
  };

  $scope.getUserInfo = function() {
   $http.get('/CafeteriaApp.Backend/Requests/Customer.php')
   .then(function(response) {
      $scope.customerInfo = response.data;
      $scope.userId = $scope.customerInfo.UserId;
      $scope.recepientName= $scope.customerInfo.FirstName+' '+$scope.customerInfo.LastName;
      $scope.phone= $scope.customerInfo.PhoneNumber;
      $http.get('/CafeteriaApp.Backend/Requests/Location.php?userId='+$scope.userId)
      .then(function(response) {
        console.log(response);
        $scope.userLocations = response.data;
        $scope.selectedLocation = $scope.userLocations[0];
      })
   });
  };

  $scope.getOrderInfo = function() {
   $http.get('/CafeteriaApp.Backend/Requests/Order.php')
   .then(function(response) {
      $scope.orderInfo = response.data;
      $scope.orderType = response.data.Type;
      if ($scope.orderType == 1) {
        $scope.selectedType = $scope.orderTypes[1];
      }
      else {
        $scope.selectedType = $scope.orderTypes[0];
      }
      $scope.deliveryPlace=$scope.orderInfo.DeliveryPlace;
      $scope.total=$scope.orderInfo.Total;
   });
  };
 
  $scope.getpaymentMethods = function() {
   $http.get('/CafeteriaApp.Backend/Requests/PaymentMethod.php')
   .then(function(response) {
      $scope.paymentMethods = response.data;
   });
  };

  $scope.currentLocation = function () {
    $scope.places = [];
    var map,infoWindow;
    map = new google.maps.Map(document.getElementById('map'),{
      // initializations
      center: {lat: -34.397, lng: 150.644},
      zoom: 6
    });
    infoWindow = new google.maps.InfoWindow();
      // check if browser supports geolocation
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      // call places service passing in request object containing placeId (which may returned from place search response)
      var request = {
        //placeId: 'ChIJxfbuHsg9WBQR3bhtVLZHOCI' // returned from a search result
        location: pos,
        radius: '50',
        //type: ['restaurant']
      };
      service = new google.maps.places.PlacesService(map);
      service.nearbySearch(request,$scope.callback);
      //service.getDetails(request,callback);
      infoWindow.setPosition(pos);
      infoWindow.setContent('Location found.');
      infoWindow.open(map);
      map.setCenter(pos);
      }, function() {
        $scope.handleLocationError(true, infoWindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      $scope.handleLocationError(false, infoWindow, map.getCenter());
    }
  };

  $scope.callback = function(results,status) { // returned from the request to places service
    if (status == google.maps.places.PlacesServiceStatus.OK) {
      for (var i = 0; i < 3; i++) {
        var place = results[i];
        //$scope.places[i] = place;
        service.getDetails({placeId: place['place_id']},function(result,status1) {
          if (status1 == google.maps.places.PlacesServiceStatus.OK) {
            var data = {
              PlaceId: result['place_id'],
              PlaceName: result['name'],
              PlaceAddress: result['formatted_address'],
              UserId: $scope.userId
            };
            $http.post('/CafeteriaApp.Backend/Requests/Location.php',data)
            .then(function(response) {
              if (response.data != "location already exists") {
                $scope.userLocations.push([result['place_id'],result['name'],result['formatted_address']]);
                $scope.selectedLocation = $scope.userLocations[0];
              }
              console.log(response);
            });
          }
        });
      }
    }
  };

  $scope.handleLocationError = function(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                      'Error: The Geolocation service failed.' :
                      'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  };

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


  $scope.getOrderDeliveryTime = function() {
   $http.get('/CafeteriaApp.Backend/Requests/Order.php?orderId='+$scope.orderId)
   .then(function(response) {
      $scope.deliveryTimeId = response.data.Id;
      $scope.deliveryTimeDuration = response.data.Duration;
   });
  };

  $scope.getUserInfo();
  $scope.getOrderInfo();
  $scope.getpaymentMethods();
  $scope.getOrderDeliveryTime();
  // $scope.currentLocation();

}]);