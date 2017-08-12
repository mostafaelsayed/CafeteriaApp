function calculateDistance(lat1,long1,lat2,long2) {	
	var R = 6371e3; // metres
	var phai1 = lat1.toRadians();
	var phai2 = lat2.toRadians();
	var deltaPhai = (lat2-lat1).toRadians();
	var deltaLamda = (lon2-lon1).toRadians();

	var a = Math.sin(deltaPhai/2) * Math.sin(deltaPhai/2) +
	        Math.cos(phai1) * Math.cos(phai2) *
	        Math.sin(deltaLamda/2) * Math.sin(deltaLamda/2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

	var d = R * c; // distance
}