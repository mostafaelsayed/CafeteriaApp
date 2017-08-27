var map,infoWindow;

function initMap() {

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
    // var request = {
    //   placeId: 'ChIJxfbuHsg9WBQR3bhtVLZHOCI' // returned from a search result
    //   //location: pos,
    //   //radius: '500',
    //   //type: ['restaurant']
    // };

    // service = new google.maps.places.PlacesService(map);
    // //service.nearbySearch(request,callback)
    // service.getDetails(request,callback);

    infoWindow.setPosition(pos);
    infoWindow.setContent('Location found.');
    infoWindow.open(map);
    map.setCenter(pos);

    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
};

function callback(results,status) { // returned from the request to places service
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    console.log(results);
    // for (var i = 0; i < results.length; i++) {
    //   var place = results[i];
    //   //console.log(place);
    //   //createMarker(results[i]);
    // }
  }
};

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                      'Error: The Geolocation service failed.' :
                      'Error: Your browser doesn\'t support geolocation.');
  infoWindow.open(map);
};