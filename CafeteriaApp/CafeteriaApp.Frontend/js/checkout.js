// controller for order checkout
layoutApp.controller('OrderCheckout', ['$rootScope', '$scope', '$interval', '$http', 'Order_Info',
  '$httpParamSerializerJQLike',
  function($rootScope, $scope, $interval, $http, Order_Info, $httpParamSerializerJQLike) {
  $scope.orderId = $.urlParam(0);
  $scope.orderTypes = [ {id: 0, name: 'TakeAway'}, {id: 1, name: 'Delivery'} ];
  $scope.paymentMethods = [ {id: 1, name: 'Paypal'}, {id: 2, name: 'Card'}, {id: 3, name: 'Cash'} ];
  $scope.deliveryFee = 0;
  $scope.taxFee = 0;
  $scope.subTotal = 0;
  $scope.loading = 0;
  $scope.csrf_token = document.getElementById('csrf_token').value;

  $scope.confirmOrder = function() {
    alertify.confirm('Are you sure you want to submit order?', function(e) {
      if (e) {
        localStorage.setItem('submit', 1);

        $http({
          method: 'put',
          url: '/myapi/Order/cashflag/1',
          data: {csrf_token: $scope.csrf_token}, 
        }).then(function(response) {
          if (response.data == 'error') {
            document.location = '/public/error';
          }
          else {
            document.location = '/public/categories';
          }
        });
      }
      else {
        return false;
      }
    })
  }

  $scope.discardOrder = function() {
    orderItems = $rootScope.orderItems;

    alertify.confirm('Are your sure you want to discard order?', function(e) {
      if (e) {
        for (var i = 0; i < orderItems.length; i++) {
          Order_Info.deleteOrderItem(orderItems[i]);
        }

        localStorage.setItem('discard', 1);
        document.location = '/public/categories';
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
  $scope.formatted_address = '';

  $scope.changeLoc = function() {
    $http.put('/myapi/OrderLocation', $scope.myPos)
    .then(function(response) {
    });
  };

  $scope.changeType = function() {
    if ($scope.selectedType.name == 'Delivery') { // delivery
      document.getElementsByClassName('map-wrapper')[0].style.display = 'block';
      document.getElementsByClassName('map-wrapper')[0].style.paddingLeft = '250px';
        document.getElementsByClassName('map-wrapper')[0].style.paddingRight = '250px';
      // document.getElementsByTagName('form')[0].classList.add('col-lg-4');
      // document.getElementsByClassName('map-wrapper')[0].classList.add('col-lg-4');
      // document.getElementsByClassName('locBut')[0].classList.add('col-lg-4');
      document.getElementsByTagName('form')[0].style.width = '350px';
      $scope.loading = 1;

      $http.put('/myapi/Order/type/Delivery', {csrf_token: $scope.csrf_token}).then(function(response) {
        console.log(response);
        $scope.deliveryFee = parseFloat(response.data);
        $scope.total += $scope.deliveryFee;
        // $http.get('/myapi/OrderLocation/orderId/' + $scope.orderId)
        // .then(function(response) {
          // if ( (response.data != "") ) {
          //   $scope.myPos.lat = parseFloat(response.data.Lat);
          //   $scope.myPos.lng = parseFloat(response.data.Lng);
          //   $scope.changeLocOnMap(1);
          // }
          // else {
            $scope.locInit(2);
          // }
        // });

        alertify.success('order type is now delivery');
      });

      $scope.confirmLocation(1);
    }
    else if ($scope.selectedType.name == 'TakeAway') { // take away
      // document.getElementsByTagName('form')[0].classList.remove('col-lg-4');
      // document.getElementsByClassName('map-wrapper')[0].classList.remove('col-lg-4');
      // document.getElementsByClassName('locBut')[0].classList.remove('col-lg-4');
      document.getElementsByTagName('form')[0].style.width = '500px';

      $http.put('/myapi/Order/type/TakeAway', {csrf_token: $scope.csrf_token}).then(function(response) {
        $scope.total -= $scope.deliveryFee;
        $scope.deliveryFee = 0;
        alertify.success('order type is now take away');
      });

      document.getElementsByClassName('map-wrapper')[0].style.display = 'none';
      $scope.myMarker.setMap(null);

    }
  };

  $scope.changePaymentMethod = function() {
    var data = {
      paymentMethod: $scope.selectedMethod.name,
    };

    $http.put('/myapi/Order', data).then(function(response) {
      if ($scope.selectedMethod.name == 'Paypal') { // paypal
        alertify.success('You will pay with PayPal');
      }
      else if ($scope.selectedMethod.name == 'Card') { // card
        alertify.success('You will pay with Card');
      }
      else if ($scope.selectedMethod.name == 'Cash') { // cash
        alertify.success('You will pay Cash');
      }
    })
  };

  $scope.returnToMyCurrentLocation = function() {
      $scope.loading = 1;
      $scope.locInit(1);
  };

  $scope.changeLocOnMap = function(a=0) {
    if (a == 0) {
      $scope.myMarker = new google.maps.Marker({ // add marker on your current location on the map
        map: $scope.map,
        position: $scope.myPos
      });
    }

    // add info window to display text at the user location to help him identify the location better
    $scope.infoWindow.setPosition($scope.myPos);
    $scope.map.setCenter($scope.myPos); // center of map is the current location
    $scope.infoWindow.setContent('Your Location'); // text is 'Your Location'
    $scope.infoWindow.open($scope.map, $scope.myMarker); // position the info window in the map in the marker
  }

  $scope.locInit = function(b=0) {
    if (navigator.geolocation) { // browser supports geolocation to find your current location
      navigator.geolocation.getCurrentPosition(function(position) {
        if (($scope.myPos.lat == 0 && $scope.myPos.lng == 0) || b == 1) {
          $scope.myPos.lat = Math.round(1000000 * position.coords.latitude) / 1000000;
          $scope.myPos.lng = Math.round(1000000 * position.coords.longitude) / 1000000;
        }

        if (b != 1) {
          $scope.changeLocOnMap();
        }

        if (b == 2) {
          $scope.loading = 0;
          $http.post('/myapi/OrderLocation', $scope.myPos).then(function(response) {
          });
        }
        else if (b == 1) {
          $scope.changeLoc();
          $scope.myMarker.setMap(null);
          $scope.changeLocOnMap();
          $scope.formatted_address = '';
          $scope.loading = 0;
        }
        
      }, function(error) {
        console.log(error);
      });
    } else {
      // Browser doesn't support Geolocation
      console.log('location not supported in your browser');
    }
  };

  $scope.getUserInfo = function() {
    $http.get('/myapi/Customer')
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

      if (a != 1) {
        $scope.geocodeLatLng();
      }
    }

    if (a == undefined) {
      alertify.success('Location Changed');
    }
  };

  $scope.getOrderInfo = function() {

    $http.get('/myapi/Order')
    .then(function(response) {
      $scope.orderInfo = response.data;
      $scope.orderType = response.data.Type;
      var paymentMethod = response.data.PaymentMethod;
      $scope.deliveryFee = response.data.DeliveryFee;
      $scope.taxFee = response.data.TaxFee;

      if (paymentMethod == 'Paypal') {
        $scope.selectedMethod = $scope.paymentMethods[0];
      }
      else if (paymentMethod == 'Card') {
        $scope.selectedMethod = $scope.paymentMethods[1];
      }
      else {
        $scope.selectedMethod = $scope.paymentMethods[2];
      }

      if ($scope.orderType == "Delivery") {
        document.getElementsByClassName('map-wrapper')[0].style.display = 'block';
        document.getElementsByClassName('map-wrapper')[0].style.paddingLeft = '250px';
        document.getElementsByClassName('map-wrapper')[0].style.paddingRight = '250px';
        // document.getElementsByTagName('form')[0].classList.add('col-lg-4');
        // document.getElementsByClassName('map-wrapper')[0].classList.add('col-lg-4');
        // document.getElementsByClassName('locBut')[0].classList.add('col-lg-4');
        document.getElementsByTagName('form')[0].style.width = '300px';
        
        $http.get('/myapi/OrderLocation/orderId/' + $scope.orderId)
        .then(function(response) {
          if ( (response.data != "") ) {
            $scope.myPos.lat = parseFloat(response.data.Lat);
            $scope.myPos.lng = parseFloat(response.data.Lng);
            $scope.changeLocOnMap();
          }
          else {
            $scope.returnToMyCurrentLocation();
            $http.post('/myapi/OrderLocation', $scope.myPos).then(function(response) {
            });

            $scope.changeLocOnMap();
          }
        });
      }
      else { // take away
        // document.getElementsByTagName('form')[0].classList.remove('col-lg-4');
        // document.getElementsByClassName('map-wrapper')[0].classList.remove('col-lg-4');
        // document.getElementsByClassName('locBut')[0].classList.remove('col-lg-4');
      }

      if ($scope.orderType == "Delivery") { // delivery
        $scope.selectedType = $scope.orderTypes[1];
      }
      else { // take away
        $scope.selectedType = $scope.orderTypes[0];
      }

      $scope.total = parseFloat($scope.orderInfo.Total);
      $scope.subTotal = ($scope.total - $scope.deliveryFee - $scope.taxFee).toFixed(2);

      $http.get('/myapi/Fee')
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
    $scope.infoWindow.setMap(null);

    $scope.myMarker.setPosition({
      lat: event.latLng.lat(),
      lng: event.latLng.lng()
    });

    $scope.myPos.lat = Math.round(10000 * $scope.myMarker.getPosition().lat() ) / 10000;
    $scope.myPos.lng = Math.round(10000 * $scope.myMarker.getPosition().lng() ) / 10000;
  });

  $scope.getUserInfo();
  $scope.getOrderInfo();

  $scope.geocoder = new google.maps.Geocoder;

  $scope.geocodeLatLng = function() {
    var latlng = {lat: $scope.myPos.lat, lng: $scope.myPos.lng};
    $scope.geocoder.geocode({'location': latlng}, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
          $scope.$apply(function() {
            $scope.formatted_address = results[0].formatted_address;
          })

          $scope.myMarker.position = latlng;
          $scope.myMarker.map = $scope.map;
          $scope.infoWindow = new google.maps.InfoWindow();
          $scope.infoWindow.setMap($scope.map);
          $scope.infoWindow.setPosition($scope.myPos);
          //$scope.infoWindow.setContent('The New Location');
          $scope.infoWindow.open($scope.map, $scope.marker);
        }
        else {
          window.alert('No results found');
        }
      }
      else {
        window.alert('Geocoder failed due to: ' + status);
      }
    });
  }
}]);