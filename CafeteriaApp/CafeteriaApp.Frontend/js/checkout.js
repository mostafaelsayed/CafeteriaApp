
// controller for order checkout
layoutApp.controller('OrderCheckout', ['$rootScope', '$scope', '$interval', '$http', '$location', 'Order_Info',
  function($rootScope, $scope, $interval, $http, $location, Order_Info) {
  $scope.orderId = $location.search().orderId;
  $scope.orderTypes = [ {id: 0, name: "Take Away"}, {id: 1, name: "Delivery"} ];
  $scope.paymentMethods = [ {id: 1, name: "PayPal"}, {id: 2, name: "Credit Card"}, {id: 3, name: "Cash"} ];
  localStorage.setItem("submit", 1);

  $scope.deliveryFee = 0;
  $scope.taxFee = 0;
  $scope.subTotal = 0;

  $scope.confirmOrder = function() {
    alertify.confirm("Are Your sure you Want to Submit Order?", function(e) {
      if (e) {
        document.getElementsByClassName('inbut')[0].click();
      }
      else {
        return false;
      }
    })
  }

  $scope.discardOrder = function() {
    orderItems = $rootScope.orderItems;
    alertify.confirm("Are Your sure you Want to Discard Order?", function(e) {
      if (e) {
        for (var i = 0; i < orderItems.length; i++) {
          Order_Info.deleteOrderItem(orderItems[i]);
        }

        localStorage.setItem("discard", 1);
        document.location = document.referrer;
      }
    })
  };

  $scope.map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10
  });

  $scope.myPos = {
    lat: 0,
    lng: 0
  }

  $scope.infoWindow = new google.maps.InfoWindow();

  $scope.changeLoc = function() {
    $http.post('../../CafeteriaApp.Backend/Requests/Location.php', $scope.myPos)
    .then(function(response) {
      var data = {
        locationId: response.data
      };

      $http.put('../../CafeteriaApp.Backend/Requests/Order.php', data);
    });
  };

  $scope.changeType = function() {
    if ($scope.selectedType.id == 1) { // delivery
      document.getElementsByClassName('wrapper')[0].style.visibility = 'visible';
      $http.put('../../CafeteriaApp.Backend/Requests/Order.php?type=1').then(function(response) {
        $scope.deliveryFee = parseInt(response.data);
        $scope.total += $scope.deliveryFee;
        alertify.success('order type is now delivery');
      });

      $scope.locInit();
      $scope.confirmLocation(1);
    }
    else if ($scope.selectedType.id == 0) { // take away
      $http.put('../../CafeteriaApp.Backend/Requests/Order.php?type=0').then(function(response) {
        $scope.total -= $scope.deliveryFee;
        $scope.deliveryFee = 0;
        alertify.success('order type is now take away');
      });
      document.getElementsByClassName('wrapper')[0].style.visibility = 'hidden';
    }
  };

  $scope.changePaymentMethod = function() {
    var data = {
      paymentMethodId: $scope.selectedMethod.id
    };
    $http.put('../../CafeteriaApp.Backend/Requests/Order.php', data).then(function(response) {
      //console.log($scope.selectedMethod.id);
      if ($scope.selectedMethod.id == 1) { // paypal
        alertify.success('you will be pay with PayPal');
      }
      else if ($scope.selectedMethod.id == 2) { // credit
        alertify.success('you will be pay with Credit Card');
      }
      else if ($scope.selectedMethod.id == 3) { // cash
        alertify.success('you will be pay Cash');
      }
    })
  };

  $scope.returnToMyCurrentLocation = function() {
    alertify.success('Location Changed');
    $scope.myPos.lat = 0;
    $scope.myPos.lng = 0;
    $scope.myMarker.setMap(null);
    $scope.locInit(1);
  };

  $scope.locInit = function(b) {
    if (navigator.geolocation) { // browser supports geolocation to find your current location
      navigator.geolocation.getCurrentPosition(function(position) {
        if ($scope.myPos.lat == 0 && $scope.myPos.lng == 0) {
          $scope.myPos = {
            lat: Math.round(10000 * position.coords.latitude) / 10000,
            lng: Math.round(10000 * position.coords.longitude) / 10000
          };

          $scope.myMarker = new google.maps.Marker({ // add marker on your current location on the map
            map: $scope.map,
            position: $scope.myPos
          });

          // add info window to display text at the user location to help him identify the location better
          $scope.infoWindow.setPosition($scope.myPos);
          $scope.map.setCenter($scope.myPos); // center of map is the current location
          $scope.infoWindow.setContent('Your Location'); // text is 'Your Location'
          $scope.infoWindow.open($scope.map, $scope.myMarker); // position the info window in the map in the marker

          if (b == 1) {
            $scope.changeLoc();
          }
        }
      }, function() {
        $scope.handleLocationError( true, $scope.infoWindow, $scope.map.getCenter() );
      });
    } else {
      // Browser doesn't support Geolocation
      $scope.handleLocationError( false, $scope.infoWindow, $scope.map.getCenter() );
    }
  };

  // $scope.discardOrder = function() {
  //   $http.delete('../../CafeteriaApp.Backend/Requests/Order.php?orderId=' + $scope.orderId)
  //   .then(function(response) {
  //     document.location = "../../CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php";
  //   });
  // };

  $scope.getUserInfo = function() {
    $http.get('../../CafeteriaApp.Backend/Requests/Customer.php')
    .then(function(response) {
      $scope.customerInfo = response.data;
      $scope.userId = $scope.customerInfo.UserId;
      $scope.recepientName = $scope.customerInfo.FirstName + ' ' + $scope.customerInfo.LastName;
      $scope.phone = $scope.customerInfo.PhoneNumber;
   });
  };

  $scope.confirmLocation = function(a) {
    if ($scope.myPos.lat !== 0 && $scope.myPos.lng !== 0) {
      $scope.changeLoc();
    }

    if (a == undefined) {
      alertify.success('Location Changed');
    }
  };

  $scope.getOrderInfo = function() {
    $http.get('../../CafeteriaApp.Backend/Requests/Order.php')
    .then(function(response) {
      console.log(response);
      $scope.orderInfo = response.data;
      $scope.orderType = response.data.Type;
      var paymentMethodId = response.data.PaymentMethodId;
      $scope.deliveryFee = response.data.DeliveryFee;
      $scope.taxFee = response.data.TaxFee;
      //$scope.selectedMethod = response.data.PaymentMethodId;

      if (paymentMethodId == 1) {
        $scope.selectedMethod = $scope.paymentMethods[0];
      }
      else if (paymentMethodId == 2) {
        $scope.selectedMethod = $scope.paymentMethods[1];
      }
      else {
        $scope.selectedMethod = $scope.paymentMethods[2];
      }

      if ($scope.orderType == 1) {
        document.getElementsByClassName('wrapper')[0].style.visibility = 'visible';
        $http.get('../../CafeteriaApp.Backend/Requests/OrderLocation.php?orderId=' + $scope.orderId)
        .then(function(response) {
          if ( !isNaN(response.data.Lat) ) {
            $scope.myPos.lat = parseFloat(response.data.Lat);
            $scope.myPos.lng = parseFloat(response.data.Lng);
          }

          if (response.data == "") {
            $scope.locInit();
          }

          $scope.myMarker = new google.maps.Marker({ // add marker on your current location on the map
            map: $scope.map,
            position: $scope.myPos
          });

          $scope.infoWindow.setPosition($scope.myPos);
          $scope.map.setCenter($scope.myPos); // center of map is the current location
          $scope.infoWindow.open($scope.map, $scope.myMarker); // position the info window in the map in the marker
          $scope.infoWindow.setContent('Your Location'); // text is 'Your Location'
        });
      }

      if ($scope.orderType == 1) { // delivery
        $scope.selectedType = $scope.orderTypes[1];
      }
      else { // take away
        $scope.selectedType = $scope.orderTypes[0];
      }

      $scope.total = parseFloat($scope.orderInfo.Total);
      $scope.subTotal = $scope.total - $scope.deliveryFee - $scope.taxFee;

      $http.get('../../CafeteriaApp.Backend/Requests/Fee.php')
      .then(function(response) {
        
      })
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

  google.maps.event.addListener($scope.map, 'click', function(event) { // listener to click event on the map
    $scope.myMarker.setPosition({
      lat: event.latLng.lat(),
      lng: event.latLng.lng()
    });

    $scope.myPos.lat = Math.round(10000 * $scope.myMarker.getPosition().lat() ) / 10000;
    $scope.myPos.lng = Math.round(10000 * $scope.myMarker.getPosition().lng() ) / 10000;
  });

  $scope.handleLocationError = function(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                      'Error: The Geolocation service failed.' :
                      'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  };

  $scope.getUserInfo();
  $scope.getOrderInfo();
  //$scope.selectedMethod = $scope.paymentMethods[0];
}]);