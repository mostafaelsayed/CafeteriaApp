
// controller for order checkout
layoutApp.controller('OrderCheckout',['$scope','$http','$location',function ($scope,$http,$location) {

  $scope.orderId = $location.search().orderId;
  $scope.selectedMethod = "";
  $scope.categoryId = $location.search().categoryId;
  $scope.orderTypes = [{id: 0,name: "Take Away"},{id: 1,name: "Delivery"}];

  $scope.map = new google.maps.Map(document.getElementById('map'),{
    // initializations
    zoom: 10
  });

  $scope.my = 1;

  $scope.nearbyFlag = 0;

  $scope.infoWindow = new google.maps.InfoWindow();

  if (navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(function(position) {

    $scope.myPos = {
      lat: position.coords.latitude,
      lng: position.coords.longitude
    };

    $scope.myMarker = new google.maps.Marker({
      map: $scope.map,
      position: $scope.myPos
    });

    $scope.infoWindow.setPosition($scope.myPos);
    $scope.map.setCenter($scope.myPos);
    $scope.infoWindow.setContent('Your Location');
    $scope.infoWindow.open($scope.map,$scope.myMarker);
    
    // call places service passing in request object containing placeId (which may returned from place search response)
    var request = {
      //placeId: 'ChIJxfbuHsg9WBQR3bhtVLZHOCI' // returned from a search result
      location: $scope.myPos,
      radius: '500',
      query: 'pizza hut Egypt cairo' // in case of text search
      //type: ['restaurant']
    };

    service = new google.maps.places.PlacesService($scope.map);
    //service.nearbySearch(request,$scope.callback);
    service.textSearch(request,$scope.callback);


    //service.getDetails(request,callback);
    }, function() {
      $scope.handleLocationError(true,$scope.infoWindow,$scope.map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    $scope.handleLocationError(false,$scope.infoWindow,$scope.map.getCenter());
  }

  $scope.discardOrder = function() {
   $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php?orderId=' + $scope.orderId)
   .then(function(response) {
      document.location =  "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";
   });
  };

  $scope.getUserInfo = function() {
   $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Customer.php')
   .then(function(response) {
      $scope.customerInfo = response.data;
      $scope.userId = $scope.customerInfo.UserId;
      $scope.recepientName = $scope.customerInfo.FirstName + ' ' + $scope.customerInfo.LastName;
      $scope.phone = $scope.customerInfo.PhoneNumber;
      // $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Location.php?userId='+$scope.userId)
      // .then(function(response) {
      //   console.log(response);
      //   $scope.userLocations = response.data;
      //   $scope.selectedLocation = $scope.userLocations[0];
      // })
   });
  };

  $scope.getOrderInfo = function() {
   $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php')
   .then(function(response) {
      $scope.orderInfo = response.data;
      $scope.orderType = response.data.Type;
      if ($scope.orderType == 1) {
        $scope.selectedType = $scope.orderTypes[1];
      }
      else {
        $scope.selectedType = $scope.orderTypes[0];
      }
      $scope.deliveryPlace = $scope.orderInfo.DeliveryPlace;
      $scope.total = $scope.orderInfo.Total;
   });
  };
 
  $scope.getpaymentMethods = function() {
   $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/PaymentMethod.php')
   .then(function(response) {
      $scope.paymentMethods = response.data;
   });
  };

  $scope.addMarker = function(map,infoWindow,place) {

    var marker = new google.maps.Marker({
      map: map,
      position: place.geometry.location,
      icon: {
        url: 'https://developers.google.com/maps/documentation/javascript/images/circle.png',
        anchor: new google.maps.Point(10, 10),
        scaledSize: new google.maps.Size(10, 17)
      }
    });

    service = new google.maps.places.PlacesService(map);

    // google.maps.event.addListener(marker, 'click', function() {
    //   service.getDetails(place, function(result, status) {
    //     if (status !== google.maps.places.PlacesServiceStatus.OK) {
    //       console.error(status);
    //       return;
    //     }
        
    //     infoWindow.setContent(result.name);

    //     infoWindow.open(map,marker);
    //   });
    // });

  };

  $scope.findPlaceLocation = function(location,pos) {

    $scope.nearbyFlag = 0;

    if (pos === undefined) {

      var position = {
        lat: location.lat(),
        lng: location.lng()
      }

      var placeMarker = new google.maps.Marker({
        map: $scope.map,
        position: position
      });

      $scope.infoWindow.setPosition(position);
      $scope.infoWindow.setContent('Closest One');
      $scope.map.setCenter(position);
      $scope.infoWindow.open($scope.map,placeMarker);
      //$scope.map.setZoom(10);
      $scope.my = 0;

      google.maps.event.addListener(placeMarker, 'click', function() {
        service.getDetails($scope.closestPlace, function(result, status) {
          if (status !== google.maps.places.PlacesServiceStatus.OK) {
            console.error(status);
            return;
          }
          
          $scope.infoWindow.setContent(result.name);

          $scope.infoWindow.open($scope.map,placeMarker);

        });

      });
      //$scope.addMarker($scope.map,$scope.infoWindow,$scope.closestPlace);
      console.log($scope.minDistance);

    }

    else {
      $scope.my = 1;
      $scope.infoWindow.setPosition($scope.myPos);
      $scope.infoWindow.setContent('Your Location');
      $scope.map.setCenter($scope.myPos);
      $scope.infoWindow.open($scope.map,$scope.myMarker);
      //$scope.map.setZoom(18);
    }

  }

  $scope.callback = function(results,status) { // returned from the request to places service
    console.log(results);

    $scope.minDistance = 100000000000;
    $scope.closestPlace = "";
    if (status == google.maps.places.PlacesServiceStatus.OK) {
      //console.log(results[0].geometry.location.lat());
      //console.log(results[0]);
      //console.log(results);
      for (var i = 0; i < results.length; i++) {
        var dis = calculateDistance($scope.myPos.lat,$scope.myPos.lng,results[i].geometry.location.lat(),results[i].geometry.location.lng());
        if ($scope.minDistance > dis) {
          $scope.minDistance = dis;
          $scope.closestPlace = results[i];
          //console.log($scope.minDistance);
          //console.log($scope.closestPlace);
        }
        
      }

      //console.log($scope.minDistance);

      var place = $scope.closestPlace;

      $scope.addMarker($scope.map,$scope.infoWindow,$scope.closestPlace);

      // if ($scope.nearbyFlag == 1) { // nearby search
      //   $scope.nearbyFlag = 0;
      //   console.log(1);

      //   service.getDetails({placeId: place['place_id']},function(result,status1) {
      //     if (status1 == google.maps.places.PlacesServiceStatus.OK) {
      //       var data = {
      //         PlaceId: result['place_id'],
      //         PlaceName: result['name'],
      //         PlaceAddress: result['formatted_address'],
      //         UserId: $scope.userId
      //       };
      //       $http.post('/CafeteriaApp.Backend/Requests/Location.php',data)
      //       .then(function(response) {
      //         if (response.data != "location already exists") {
      //           $scope.userLocations.push([result['place_id'],result['name'],result['formatted_address']]);
      //           $scope.selectedLocation = $scope.userLocations[0];
      //         }
      //       });
      //     }
      //   });
      // }
    }
  };

  $scope.handleLocationError = function(browserHasGeolocation,infoWindow,pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                      'Error: The Geolocation service failed.' :
                      'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  };

  $scope.getOrderDeliveryTime = function() {
   $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php?orderId=' + $scope.orderId)
   .then(function(response) {
    console.log(response.data);
      $scope.deliveryTimeId = response.data;
      //console.log($scope.deliveryTimeId);
      $scope.deliveryTimeDuration = response.data.Duration;
   });
  };

  $scope.getUserInfo();
  $scope.getOrderInfo();
  $scope.getpaymentMethods();
  $scope.getOrderDeliveryTime();

}]);