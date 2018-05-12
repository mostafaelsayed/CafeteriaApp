function calculateDistance(lat1, long1, lat2, long2) {	
	var R = 6371e3; // metres
	var phai1 = toRadians(lat1);
	var phai2 = toRadians(lat2);
	var deltaPhai = toRadians(lat2 - lat1);
	var deltaLamda = toRadians(long2 - long1);

	var a = Math.sin(deltaPhai / 2) * Math.sin(deltaPhai / 2) +
	        Math.cos(phai1) * Math.cos(phai2) *
	        Math.sin(deltaLamda / 2) * Math.sin(deltaLamda / 2);
	var c = 2 * Math.atan2( Math.sqrt(a), Math.sqrt(1 - a) );

	var d = R * c; // distance in km

	return d;
}

function toRadians(deg) {
	return deg * Math.PI / 180;
}