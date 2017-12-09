
// controller for order checkout
layoutApp.controller('OrderCheckout', ['$scope', '$http', '$location', function ($scope, $http, $location) {
  $scope.orderId = $location.search().orderId;
  $scope.selectedMethod = "";
  $scope.categoryId = $location.search().categoryId;
  $scope.orderTypes = [ {id: 0,name: "Take Away"}, {id: 1,name: "Delivery"} ];

  // $scope.map = new google.maps.Map(document.getElementById('map'), {
  //   zoom: 10
  // });

  // $scope.myPos = {
  //   lat: 0,
  //   lng: 0
  // }

  // $scope.infoWindow = new google.maps.InfoWindow();

  // $scope.changeType = function() {
  //   if ($scope.selectedType.id == 1) { // delivery
  //     document.getElementsByClassName('wrapper')[0].style.visibility = "visible";
  //     $scope.locInit();
  //   }
  // }

  // $scope.locInit = function() {
  //   if (navigator.geolocation) { // browser supports geolocation to find your current location

  //     navigator.geolocation.getCurrentPosition(function(position) {

  //       $scope.myPos.lat = Math.round(10000 * position.coords.latitude) / 10000, // latitude
  //       $scope.myPos.lng = Math.round(10000 * position.coords.longitude) / 10000 // longitude

  //       $scope.myMarker = new google.maps.Marker({ // add marker on your current location on the map
  //         map: $scope.map,
  //         position: $scope.myPos
  //       });

  //       //$http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Location.php', $scope.myPos);
  //       //$http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/order.php', $scope.myPos);

  //       // add info window to display text at the user location to help him identify the location better
  //       $scope.infoWindow.setPosition($scope.myPos);
  //       $scope.map.setCenter($scope.myPos); // center of map is the current location
  //       $scope.infoWindow.setContent('Your Location'); // text is 'Your Location'
  //       $scope.infoWindow.open($scope.map, $scope.myMarker); // position the info window in the map in the marker
  //     }, function() {
  //       $scope.handleLocationError( true, $scope.infoWindow, $scope.map.getCenter() );
  //     });
  //   } else {
  //     // Browser doesn't support Geolocation
  //     $scope.handleLocationError( false, $scope.infoWindow, $scope.map.getCenter() );
  //   }
  // }

  $scope.discardOrder = function() {
    $http.delete('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php?orderId=' + $scope.orderId)
    .then(function(response) {
      document.location = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";
    });
  };

  $scope.getUserInfo = function() {
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Customer.php')
    .then( function(response) {
      $scope.customerInfo = response.data;
      $scope.userId = $scope.customerInfo.UserId;
      $scope.recepientName = $scope.customerInfo.FirstName + ' ' + $scope.customerInfo.LastName;
      $scope.phone = $scope.customerInfo.PhoneNumber;
   } );
  };

  $scope.confirmLocation = function() {
    console.log($scope.myPos);
    $http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Location.php', $scope.myPos)
    .then(function(response) {
      console.log(response);
      $scope.lastLoc = response.data;
      var data = {
        locationId: $scope.lastLoc
      }
      $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php', data)
      .then(function(response) {
        console.log(response);
      })
    });
  };

  $scope.getOrderInfo = function() {
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php')
    .then(function(response) {
      $scope.orderInfo = response.data;
      $scope.orderType = response.data.Type;

      if ($scope.orderType == 1) {
        $scope.locInit();
      }

      if ($scope.orderType == 1) { // delivery
        $scope.selectedType = $scope.orderTypes[1];
      }
      else { // take away
        $scope.selectedType = $scope.orderTypes[0];
      }

      $scope.total = $scope.orderInfo.Total;
    });
  };
 
  $scope.getpaymentMethods = function() {
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/PaymentMethod.php')
    .then(function(response) {
      $scope.paymentMethods = response.data;
    });
  };

  $scope.addMarker = function(position) {
    var marker = new google.maps.Marker({
      map: $scope.map,
      position: position,
      icon: {
        url: 'https://developers.google.com/maps/documentation/javascript/images/circle.png',
        anchor: new google.maps.Point(10, 10),
        scaledSize: new google.maps.Size(10, 17)
      }
    });
  };

  // google.maps.event.addListener($scope.map, 'click', function(event) { // listener to click event on the map
  //   $scope.myMarker.setPosition({
  //     lat: event.latLng.lat(),
  //     lng: event.latLng.lng()
  //   });

  //   $scope.myPos.lat = Math.round(10000 * $scope.myMarker.getPosition().lat() ) / 10000;
  //   $scope.myPos.lng = Math.round(10000 * $scope.myMarker.getPosition().lng() ) / 10000;

  //   console.log($scope.myPos.lat);
  // });

  $scope.findPlaceLocation = function(location, pos) {
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
      $scope.infoWindow.open($scope.map, placeMarker);
      $scope.my = 0;

      google.maps.event.addListener(placeMarker, 'click', function() {
        service.getDetails($scope.closestPlace, function(result, status) {
          if (status !== google.maps.places.PlacesServiceStatus.OK) {
            console.error(status);
            return;
          }
          
          $scope.infoWindow.setContent(result.name);
          $scope.infoWindow.open($scope.map, placeMarker);
        });
      });

      console.log($scope.minDistance);
    }

    else {
      $scope.my = 1;
      $scope.infoWindow.setPosition($scope.myPos);
      $scope.infoWindow.setContent('Your Location');
      $scope.map.setCenter($scope.myPos);
      $scope.infoWindow.open($scope.map, $scope.myMarker);
    }

  }

  $scope.callback = function(results, status) { // returned from the request to places service
    console.log(results);
    $scope.minDistance = 100000000000;
    $scope.closestPlace = "";
    if (status == google.maps.places.PlacesServiceStatus.OK) {
      for (var i = 0; i < results.length; i++) {
        var dis = calculateDistance( $scope.myPos.lat, $scope.myPos.lng, results[i].geometry.location.lat(), results[i].geometry.location.lng() );
        
        if ($scope.minDistance > dis) {
          $scope.minDistance = dis;
          $scope.closestPlace = results[i];
        }
      }

      var place = $scope.closestPlace;
      $scope.addMarker($scope.map, $scope.infoWindow, $scope.closestPlace);
    }
  };

  $scope.handleLocationError = function(browserHasGeolocation, infoWindow, pos) {
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
      $scope.deliveryTimeDuration = response.data.Duration;
    });
  };

  $scope.getUserInfo();
  $scope.getOrderInfo();
  $scope.getpaymentMethods();
  $scope.getOrderDeliveryTime();
}]);