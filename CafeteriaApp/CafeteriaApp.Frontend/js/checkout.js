// controller for order checkout
layoutApp.controller('OrderCheckout', ['$rootScope', '$scope', '$interval', '$http', 'Order_Info',
  '$httpParamSerializerJQLike',
  function($rootScope, $scope, $interval, $http, Order_Info, $httpParamSerializerJQLike) {

  $scope.orderId = $.urlParam('orderId');
  $scope.orderTypes = [ {id: 0, name: "Take Away"}, {id: 1, name: "Delivery"} ];
  $scope.paymentMethods = [ {id: 1, name: "PayPal"}, {id: 2, name: "Credit Card"}, {id: 3, name: "Cash"} ];
  $scope.deliveryFee = 0;
  $scope.taxFee = 0;
  $scope.subTotal = 0;

  $scope.csrf_token = document.getElementById('csrf_token').value;

  $scope.confirmOrder = function() {
    alertify.confirm("Are you sure you want to submit order?", function(e) {
      if (e) {
        localStorage.setItem("submit", 1);
        // $http({
        //   method: 'put',
        //   url: '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php?cashflag=1',
        //   data: $httpParamSerializerJQLike({csrf_token: 'sd'}), 
        //   headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        // }).then(function(response) {
        //   console.log(response);
        //   if (response.data == false) {
        //     // document.location = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/error.php";
        //     alertify.error('error occured');
        //   }
        //   else {
        //     //document.location = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/categories.php";
        //   }
        //   //console.log(response);
        // });

        $http({
          method: 'put',
          url: '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php?cashflag=1',
          data: {csrf_token: $scope.csrf_token}, 
          //headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
          console.log(response);
          if (response.data == 'error') {
            document.location = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/error.php";
            //alertify.error('error occured');
          }
          else {
            document.location = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/categories.php";
          }
          //console.log(response);
        });

        //document.location = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/categories.php";
      }
      else {
        return false;
      }
    })
  }

  $scope.discardOrder = function() {
    orderItems = $rootScope.orderItems;
    alertify.confirm("Are your sure you want to discard order?", function(e) {
      if (e) {
        for (var i = 0; i < orderItems.length; i++) {
          Order_Info.deleteOrderItem(orderItems[i]);
        }

        localStorage.setItem("discard", 1);
        document.location = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/categories.php";
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
    $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderLocation.php', $scope.myPos)
    .then(function(response) {
      console.log(response);
    });
  };

  $scope.changeType = function() {
    if ($scope.selectedType.id == 1) { // delivery
      document.getElementsByClassName('map-wrapper')[0].style.display = 'block';
      document.getElementsByTagName('form')[0].classList.add('col-lg-4');
      document.getElementsByClassName('map-wrapper')[0].classList.add('col-lg-4');
      document.getElementsByClassName('locBut')[0].classList.add('col-lg-4');
      document.getElementsByTagName('form')[0].style.width = '350px';

      $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php?type=1', {csrf_token: $scope.csrf_token}).then(function(response) {
        $scope.deliveryFee = parseInt(response.data);
        $scope.total += $scope.deliveryFee;
        $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderLocation.php?orderId=' + $scope.orderId)
        .then(function(response) {
          if ( (response.data != "") ) {
            $scope.myPos.lat = parseFloat(response.data.Lat);
            $scope.myPos.lng = parseFloat(response.data.Lng);
            $scope.changeLocOnMap();
          }
          else {
            $scope.locInit(2);
          }
        });

        alertify.success('order type is now delivery');
      });

      $scope.confirmLocation(1);
    }
    else if ($scope.selectedType.id == 0) { // take away
      document.getElementsByTagName('form')[0].classList.remove('col-lg-4');
      document.getElementsByClassName('map-wrapper')[0].classList.remove('col-lg-4');
      document.getElementsByClassName('locBut')[0].classList.remove('col-lg-4');

      $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php?type=0', {csrf_token: $scope.csrf_token}).then(function(response) {
        $scope.total -= $scope.deliveryFee;
        //console.log(response);
        $scope.deliveryFee = 0;
        alertify.success('order type is now take away');
      });

      document.getElementsByClassName('map-wrapper')[0].style.display = 'none';
      //document.getElementsByTagName('form')[0].classList.remove('col-lg-6');
    }
  };

  $scope.changePaymentMethod = function() {
    //console.log($scope.csrf_token);
    var data = {
      paymentMethodId: $scope.selectedMethod.id,
      //csrf_token: $scope.csrf_token
    };

    $http.put('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php', data).then(function(response) {
      console.log(response);
      if ($scope.selectedMethod.id == 1) { // paypal
        alertify.success('You will pay with PayPal');
      }
      else if ($scope.selectedMethod.id == 2) { // credit
        alertify.success('You will pay with Credit Card');
      }
      else if ($scope.selectedMethod.id == 3) { // cash
        alertify.success('You will pay Cash');
      }
    })
  };

  /// ???????

  $scope.returnToMyCurrentLocation = function() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        sessionStorage.setItem("lat", position.coords.latitude);
        sessionStorage.setItem("lng", position.coords.longitude);
        $scope.myPos.lat = parseFloat(sessionStorage.getItem("lat"));
        $scope.myPos.lng = parseFloat(sessionStorage.getItem("lng"));
        $scope.changeLoc();
        $scope.myMarker.setMap(null);
        $scope.changeLocOnMap();
      }, function(error) {
        //alertify.error("geolocation failure. we will use last location you were in");
      }, {timeout:5000})
    }

    $scope.myPos.lat = parseFloat(sessionStorage.getItem("lat"));
    $scope.myPos.lng = parseFloat(sessionStorage.getItem("lng"));
    $scope.changeLoc();
    $scope.myMarker.setMap(null);
    $scope.changeLocOnMap();
  };

  $scope.changeLocOnMap = function() {
    $scope.myMarker = new google.maps.Marker({ // add marker on your current location on the map
      map: $scope.map,
      position: $scope.myPos
    });

    // add info window to display text at the user location to help him identify the location better
    $scope.infoWindow.setPosition($scope.myPos);
    $scope.map.setCenter($scope.myPos); // center of map is the current location
    $scope.infoWindow.setContent('Your Location'); // text is 'Your Location'
    $scope.infoWindow.open($scope.map, $scope.myMarker); // position the info window in the map in the marker
  }

  $scope.locInit = function(b) {
    if (navigator.geolocation) { // browser supports geolocation to find your current location
      navigator.geolocation.getCurrentPosition(function(position) {
        if ($scope.myPos.lat == 0 && $scope.myPos.lng == 0) {
            $scope.myPos = {
              lat: Math.round(1000000 * position.coords.latitude) / 1000000,
              lng: Math.round(1000000 * position.coords.longitude) / 1000000
            };
          }

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
          else if (b == 2) {
            $http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderLocation.php', $scope.myPos).then(function(response) {
              console.log(response);
            });
          }
        
      }, function() {
        $scope.handleLocationError( true, $scope.infoWindow, $scope.map.getCenter() );
      });
    } else {
      // Browser doesn't support Geolocation
      $scope.handleLocationError( false, $scope.infoWindow, $scope.map.getCenter() );
    }
  };

  $scope.getUserInfo = function() {
    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Customer.php')
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

    $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Order.php')
    .then(function(response) {
      console.log(response);
      $scope.orderInfo = response.data;
      $scope.orderType = response.data.Type;
      var paymentMethodId = response.data.PaymentMethodId;
      $scope.deliveryFee = response.data.DeliveryFee;
      $scope.taxFee = response.data.TaxFee;

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
        document.getElementsByClassName('map-wrapper')[0].style.display = 'block';
        document.getElementsByTagName('form')[0].classList.add('col-lg-4');
        document.getElementsByClassName('map-wrapper')[0].classList.add('col-lg-4');
        document.getElementsByClassName('locBut')[0].classList.add('col-lg-4');
        document.getElementsByTagName('form')[0].style.width = '350px';
        
        $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderLocation.php?orderId=' + $scope.orderId)
        .then(function(response) {
          if ( (response.data != "") ) {
            $scope.myPos.lat = parseFloat(response.data.Lat);
            $scope.myPos.lng = parseFloat(response.data.Lng);
            $scope.changeLocOnMap();
          }
          else {
            $scope.myPos.lat = parseFloat( sessionStorage.getItem("lat") );
            $scope.myPos.lng = parseFloat( sessionStorage.getItem("lng") );
            $http.post('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/OrderLocation.php', $scope.myPos).then(function(response) {
              console.log(response);
            });

            $scope.changeLocOnMap();
          }
        });
      }
      else { // take away
        document.getElementsByTagName('form')[0].classList.remove('col-lg-4');
        document.getElementsByClassName('map-wrapper')[0].classList.remove('col-lg-4');
        document.getElementsByClassName('locBut')[0].classList.remove('col-lg-4');
      }

      if ($scope.orderType == 1) { // delivery
        $scope.selectedType = $scope.orderTypes[1];
      }
      else { // take away
        $scope.selectedType = $scope.orderTypes[0];
      }

      $scope.total = parseFloat($scope.orderInfo.Total);
      $scope.subTotal = $scope.total - $scope.deliveryFee - $scope.taxFee;

      $http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/Fee.php')
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

  $scope.getUserInfo();
  $scope.getOrderInfo();
}]);