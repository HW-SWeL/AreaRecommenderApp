var markers = [];


//Initialise the map
function initMap(containerName, pLat, pLng) {
	//Define initial location of camera on map and zoom level
	var mapOptions = {
	center: { lat: pLat, lng: pLng},
	zoom: 12
	};
	
	//Create map and attach to div with id 'map-canvas'
	map = new google.maps.Map(document.getElementById(containerName),	mapOptions);
}

//Plot a circle onto the global map
function addCircle(latLng, r, strokeCol, lineCol, fillOpac){
	var circle = new google.maps.Circle({
		center: latLng,
		radius: r,
		//strokeColor: strokeCol,
		strokeOpacity: 0.8,
		strokeWeight: 2
		//fillColor: lineCol,
		//fillOpacity: fillOpacity
	});          
	
	circle.setMap(map); 
}

//plot a marker onto the global map
function addMarker(latLng, title) {
	var marker = new google.maps.Marker({ // Set the marker
		position: latLng, // Position marker to coordinates
		map: map, // assign the market to our map variable
		title: title // Marker ALT Text
	});
	
	markers.push(marker);
	
	return marker;
}
