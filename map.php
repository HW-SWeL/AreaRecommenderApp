<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZg5qfeNjn_F3H1XQfAPj1x6HUuIz6lPI&v=3.exp&signed_in=true&libraries=places"></script>
<!-- Latest compiled and minified JavaScript -->
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!-- User defined functions -->
<script type="text/javascript" src="js/map.js"></script>
<script type="text/javascript" src="js/service.js"></script>
<script type="text/javascript" src="js/sidebar.js"></script>


<title>Area Information App</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/mainStyle.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

// Remove login feature and session caching
// <?php 
// 		session_start(); 
// 		if($_SESSION['username']==null) header( 'Location: index.html' ) ;
// 	?>


<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="map.php">Area Information App</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="profile.php">Profile</a></li>
					<li><a href="index.html">Logout</a></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container">


		<div class="btn-group" role="group" aria-label="..." id="topPanel">
			<button onclick="javascript:refresh();" type="button"
				class="btn btn-default topPanelElement">Refresh</button>
			<div class="btn-group topPanelElement">
				<button type="button" class="btn btn-danger">Recommend</button>
				<button type="button"
					class="btn btn-danger dropdown-toggle topPanelElement"
					data-toggle="dropdown" aria-expanded="false">
					<span class="caret"></span> <span class="sr-only">Toggle
						Dropdown</span>
				</button>
				<ul class="dropdown-menu" role="menu" id="recommenderList">
				</ul>
			</div>
			<button onclick="javascript:saveLocation();" type="button"
				class="btn btn-default topPanelElement">Save Location</button>
			<div class="btn-group topPanelElement">
				<button type="button" class="btn btn-danger ">Choose Area</button>
				<button type="button" class="btn btn-danger dropdown-toggle"
					data-toggle="dropdown" aria-expanded="false">
					<span class="caret"></span> <span class="sr-only">Toggle
						Dropdown</span>
				</button>
				<ul class="dropdown-menu areaNameDropdown" role="menu" id="areaList"></ul>
			</div>

			<div class="input-group topPanelElement">
				<input id="areaNameInput" type="text" class="form-control"
					placeholder="Area name">

				<button class="btn btn-default" type="button"
					onclick="selectLocation(getElementById('areaNameInput').value, false)">Find</button>

			</div>
			<!-- /input-group -->
		</div>

		<div class="well well-lg" id="mainContent">

			<div id="mapContainer" class="col-md-8">
				<div class="col-lg-6">
					<div class="input-group">
						<input type="text" class="form-control"
							placeholder="Search for..."> <span
							class="input-group-btn">
							<button class="btn btn-default" type="button">Go!</button>
						</span>
					</div>
					<!-- /input-group -->
				</div>
				<!-- /.col-lg-6 -->
			</div>

			<div class="col-md-4" id="sidebar"></div>

		</div>

		<script>
		function refresh(){
			removeMarkers();
		  	var sidebar = document.getElementById('sidebar');
		   	while (sidebar.firstChild) {
		   	    sidebar.removeChild(sidebar.firstChild);
		   	}

		   	var i;
		   	for(i=0;i<locations.length;i++){
		   		plotArea(locations[i]);
		   	}	
		}
		
		 function selectRankedLocation(areaName, init){
			console.log("RANKED: areaName=",areaName, locations);
	
			console.log("RANKED: markers", markers);
		
			var i;
			var found = true;
			if(init!=null) found=init;
			for(i=0;i<locations.length;i++){
				console.log("RANKED: i", locations[i], locations[i].name, areaName);
				if(locations[i].name == areaName){
					console.log("RANKED: Found match");
					showAreaInfo(areaName);

					var j;
					for(j=0;j<markers.length;j++){
						console.log("RANKED", markers[j]);
						if(markers[j].title==areaName){
							console.log("RANKED: marker found", markers[j]);
							if(selectedArea!=null) selectedArea[1].setIcon('http://www.google.com/mapfiles/kml/paddle/'+(selectedArea[1].suitability + 1)+'.png')
							selectedArea = [locations[i], markers[j]];
							markers[j].setIcon('http://www.google.com/mapfiles/kml/paddle/blu-circle.png');

							console.log("RANKED selectedArea: ", selectedArea);
							
							break;			
						}
					}
					found=true;
					break;
				}
			}
		}
		
	    function sortNumber(a,b) {
	        return a - b;
	    }

		function plotRankedLocations(data){
			var jsonData = JSON.parse(data);
			console.log("json", jsonData);

			var keys = Object.keys(jsonData);
			console.log("unsorted keys", keys);
			keys.sort(sortNumber);
			console.log("sorted keys=", keys)

			var i;
			for(i=0;i<keys.length;i++){
				var locations = jsonData[keys[i]];
				console.log(locations);

				var j;
				for(j=0;j<locations.length;j++){
					var latlng = locations[j].latlng.split(",")
				   	latlng = { lat:parseFloat(latlng[0]), lng:parseFloat(latlng[1]) };
					
					var marker = addMarker(latlng, locations[j].name);
					marker.setIcon('http://www.google.com/mapfiles/kml/paddle/'+(i+1)+'.png');
					marker.suitability = i;
					google.maps.event.addListener(marker,'click',function() {
				   	 	console.log("marker click", this);
				   	 	selectRankedLocation(this.title);
				   	});
				}
			}
		}
	
		function removeMarkers(){
			var i;
			for(i=0;i<markers.length;i++){
				markers[i].setMap(null);
			}

			markers = [];
		}
    
	    function selectLocation(areaName, init){
			console.log("areaName=",areaName, locations);
	
			console.log("markers", markers);
			
			var i;
			var found = true;
			if(init!=null) found=init;
			for(i=0;i<markers.length;i++){
				if(locations[i].name == areaName){
					console.log("Found match");
					showAreaInfo(areaName);
	
					if(selectedArea!=null) selectedArea[1].setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png')
					selectedArea = [locations[i], markers[i]];
					markers[i].setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png')
					found=true;
					break;	
				}
			}

			if(!found){
				console.log("input not found, area name=", areaName);

				geocoder.geocode( { 'address': areaName, 'componentRestrictions':{'country':'GB'}}, function(results, status) {
					console.log(results, status);
				      if (status == google.maps.GeocoderStatus.OK) {
				    	 var lat;
						 var lng;
							
				         lat = results[0].geometry.location.lat();
				         lng = results[0].geometry.location.lng();

					    var latlngSystem = {"lat":lat, "lng":lng};
						var min = findClosest(latlngSystem);

						console.log("input location=", areaName, "resultUsed=", results[0], "results=", results);
						
						//select that location
						console.log("min loc=", min);
						selectLocation(min[0].name);
										         
				      } else {
				        alert("Geocode was not successful for the following reason: " + status);
				      }
				    });
				    
			}	
		}
		
		function saveLocation() {
			if(selectedArea!=null){
				var xmlhttp;
				
				if (window.XMLHttpRequest) {
				    // code for IE7+, Firefox, Chrome, Opera, Safari
				    xmlhttp = new XMLHttpRequest();
				} else {
				    // code for IE6, IE5
				    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
				    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				        console.log(xmlhttp.responseText);
				        if(xmlhttp.responseText == "success"){	
					        alert("Location saved.");	        
				        }
				        else {
					        alert("Area already saved.");
					    }
				    }
				}
	
				console.log("selectedArea=",selectedArea);
				xmlhttp.open("GET","addSavedLocation.php?location="+selectedArea[0].name,true);
				// Removed username
// 				xmlhttp.open("GET","addSavedLocation.php?username="+username+"&location="+selectedArea[0].name,true);
				xmlhttp.send();
			}
			else{
				alert("Must select an area first.");
			}
		}
	
		function plotArea(location){
			console.log(location, location.latLng);
			var latlng = location.latLng.split(",")
		   	latlng = { lat:parseFloat(latlng[0]), lng:parseFloat(latlng[1]) };
		   	var marker = addMarker(latlng, location.name);
		    marker.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png')
		   	
		   	google.maps.event.addListener(marker,'click',function() {
		   	 	console.log("marker click", this);
		   	 	selectLocation(this.title);
		   	});
		}
	
		function showAreaInfo(areaName){			
			webService.getLocationByName(areaName).done(function(data){
			    var location = JSON.parse(data);
			    console.log(location);
	
			   	//Add a panel for each piece of information
			   	var sidebar = document.getElementById('sidebar');
			   	while (sidebar.firstChild) {
			   	    sidebar.removeChild(sidebar.firstChild);
			   	}

			   	var newOuterDiv = document.createElement('div')
				
				var heading = "Area Information";
				var headingButton = document.createElement('button')
			    headingButton.setAttribute('class','btn btn-info sidebarHeader');
				headingButton.setAttribute('type','button');
				headingButton.innerHTML = heading;
			   	
				var collapseDiv = document.createElement('div')
				collapseDiv.setAttribute('id', "areaInformation_collapse");

				var businessDiv0 = document.createElement('div');				
				businessDiv0.innerHTML = "Area Name: "+location.name;		
				collapseDiv.appendChild(businessDiv0);
				
				var businessDiv1 = document.createElement('div');				
				businessDiv1.innerHTML = "Population: "+location.population;		
				collapseDiv.appendChild(businessDiv1);

				var businessDiv2 = document.createElement('div');				
				businessDiv2.innerHTML = "% of people working age: "+location.workingPercent;		
				collapseDiv.appendChild(businessDiv2);

				var businessDiv3 = document.createElement('div');				
				businessDiv3.innerHTML = "% of people pension age: "+location.pensionPercent;
				collapseDiv.appendChild(businessDiv3);

				var businessDiv4 = document.createElement('div');				
				businessDiv4.innerHTML = "% of people child age: "+location.childPercent;	
				collapseDiv.appendChild(businessDiv4);

				newOuterDiv.appendChild(headingButton);   
				newOuterDiv.appendChild(collapseDiv);  
			   	sidebar.appendChild(newOuterDiv);
	
			   	//var cafes = "Number of cafes: "+location.cafes.length;
			   	//for(i = 0; i < location.cafes.length; i++){
			   	//	entertainment+="</br>"+location.entertainment[i].name;
			   	//}
			   	
			   	console.log("location=", location);
				sidebar.appendChild(createPanel(location.cafes, "cafes"));
				sidebar.appendChild(createPanel(location.entertainment, "entertainment"));
				sidebar.appendChild(createPanel(location.groceryShops, "grocery shops"));
				sidebar.appendChild(createPanel(location.primarySchools, "primary schools"));
				sidebar.appendChild(createPanel(location.secondarySchools, "secondary schools"));
				
				//var entertainment = "Number of entertainment: "+location.entertainment.length;
			   	//for(i = 0; i < location.entertainment.length; i++){
			   	//	entertainment+="</br>"+location.entertainment[i].name;
			    //}
				//sidebar.appendChild(createPanel(entertainment));
	
				//var groceryShops = "Number of grocery shops: "+location.groceryShops.length;
			   	//for(i = 0; i < location.groceryShops.length; i++){
			   	//	groceryShops+="</br>"+location.groceryShops[i].name;
			   	//}
				//sidebar.appendChild(createPanel(groceryShops));
	
				//var primarySchools = "Number of primary schools: "+location.primarySchools.length;
			   	//for(i = 0; i < location.primarySchools.length; i++){
			   	//	primarySchools+="</br>"+location.primarySchools[i].name;
			   	//}
				//sidebar.appendChild(createPanel(primarySchools));
	
				//var secondarySchools = "Number of secondary schools: "+location.secondarySchools.length;
			   	//for(i = 0; i < location.secondarySchools.length; i++){
			   	//	secondarySchools+="</br>"+location.secondarySchools[i].name;
			    //}
				//sidebar.appendChild(createPanel(secondarySchools));
			   
			});
		}
		
		function mapArea(areaNamePost){
			//var areaNamePost = <?php echo "'".$areaNamePost."'"; ?>; //Don't forget the extra semicolon!
		
			console.log(areaNamePost);
	
			webService.getLocationByName(areaNamePost).done(function(data){
			    var location = JSON.parse(data);
			    console.log(location);
			    
			   	var latlng = location.latlng.split(",")
			   	latlng = { lat:parseFloat(latlng[0]), lng:parseFloat(latlng[1]) };
			   	addMarker(latlng, location.name);
	
			   	//Add a panel for each piece of information
			   	var sidebar = document.getElementById('sidebar');
	
			   	var percentStats = "Population: "+location.population+
			   						"</br>% of people working age: "+location.workingPercent+
			   						"</br>% of people pension age: "+location.pensionPercent+
			   						"</br>% of people child age: "+location.childPercent;
			   	sidebar.appendChild(createPanel(percentStats));
	
			   	var cafes = "Number of cafes: "+location.cafes.length;
			   	for(i = 0; i < location.cafes.length; i++){
					cafes+="</br>"+location.cafes[i].name;
			   	}
				sidebar.appendChild(createPanel(cafes));
	
				var entertainment = "Number of entertainment: "+location.entertainment.length;
			   	for(i = 0; i < location.entertainment.length; i++){
			   		entertainment+="</br>"+location.entertainment[i].name;
			   	}
				sidebar.appendChild(createPanel(entertainment));
	
				var groceryShops = "Number of grocery shops: "+location.groceryShops.length;
			   	for(i = 0; i < location.groceryShops.length; i++){
			   		groceryShops+="</br>"+location.groceryShops[i].name;
			   	}
				sidebar.appendChild(createPanel(groceryShops));
	
				var primarySchools = "Number of primary schools: "+location.primarySchools.length;
			   	for(i = 0; i < location.primarySchools.length; i++){
			   		primarySchools+="</br>"+location.primarySchools[i].name;
			   	}
				sidebar.appendChild(createPanel(primarySchools));
	
				var secondarySchools = "Number of secondary schools: "+location.secondarySchools.length;
			   	for(i = 0; i < location.secondarySchools.length; i++){
			   		secondarySchools+="</br>"+location.secondarySchools[i].name;
			   	}
				sidebar.appendChild(createPanel(secondarySchools));
			   
			});
		}
    </script>

		<script>
		initMap("mapContainer", 55.953252000000000000, -3.188266999999996000);

		var markers = [];
		var selectedArea;	
		/**
		 Comment out username
		 var username = '<?php echo $_SESSION["username"]; ?>'; 
		 */
		var locations;
		var geocoder = new google.maps.Geocoder();
		
		$('.dropdown-toggle').dropdown();
		//TODO: Working here
		webService.getLocationsSimple().done(function(data){
			locations = JSON.parse(data);
			console.log(locations);

			for(var i = 0; i < locations.length; i++)
		    { 
	            var newNumberListItem = document.createElement("li");
	            var button = document.createElement("a");		    
			    button.par1 = locations[i].name;
			    button.text = locations[i].name;
			    button.onclick = function(d, i){
				    selectLocation(this.par1);
			    }
			    newNumberListItem.appendChild(button);
	            
	            var list = document.getElementById("areaList");            	            
	            list.appendChild(newNumberListItem);

	            //plot location on map
	            console.log(locations[i]);
	            plotArea(locations[i]);	            
	  	  	}		

			var locGet = '<?php echo $_GET["location"]; ?>';
			if(locGet!=null) selectLocation(locGet);
		});

		function distance(lat1, lon1, lat2, lon2) {
		  var R = 6371;
		  var a = 
		     0.5 - Math.cos((lat2 - lat1) * Math.PI / 180)/2 + 
		     Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
		     (1 - Math.cos((lon2 - lon1) * Math.PI / 180))/2;

		  return R * 2 * Math.asin(Math.sqrt(a));
		}

		function findClosest(latlngSystem){
			var min;
			var i;
			for(i=0;i<locations.length;i++){
				console.log(locations[i]);
				if(min==null){
					var latlngLoc = locations[i].latLng;
					var dist = distance(latlngSystem.lat, latlngSystem.lng, parseFloat(latlngLoc[0]), parseFloat(latlngLoc[1]));
					min=[locations[i], dist];
				}
				else{
					var latlngLoc = locations[i].latLng;
					latlngLoc = latlngLoc.split(",");
					var dist = distance(latlngSystem.lat, latlngSystem.lng, parseFloat(latlngLoc[0]), parseFloat(latlngLoc[1]));
					console.log("dist=", dist);
					if(dist<min[1]) min=[locations[i], dist];
				}
			}

			return min;		
		}
		
		google.maps.event.addListener(map, 'click', function(event) {
			var latlng = event.latLng;
		    var latlngSystem = {"lat":latlng.k, "lng":latlng.D};

			var min = findClosest(latlngSystem);
			
			//select that location
			console.log("min loc=", min);
			selectLocation(min[0].name);			
		});

		function recommend(preference){
			var split = preference.split(",");
			var slicePref = split.slice(2);
			console.log(slicePref, slicePref.join());

			slicePref=slicePref.join();
			slicePref = slicePref.substring(0, slicePref.length - 1);

			console.log(slicePref);
			
			var jsonPref = JSON.parse(slicePref);
			console.log("recommending for ", preference, split, jsonPref);

			var recommendations = webService.recommend(slicePref).done(function(data){
			    console.log("data", data);

				var sidebar = document.getElementById('sidebar');
			   	while (sidebar.firstChild) {
			   	    sidebar.removeChild(sidebar.firstChild);
			   	}
			    			    
			    removeMarkers();
			    plotRankedLocations(data);
			});
			    
			console.log("recommendations", recommendations);
		}

		function drawPreferenceList(json){
			var preferences = JSON.parse(json);
			console.log("Draw preferences=", preferences);

			var preferenceList = document.getElementById("recommenderList");
			console.log("Preference list: ", preferenceList);
			while(preferenceList.hasChildNodes()) {
				preferenceList.removeChild(preferenceList.childNodes[0]);
			}
			
			var i;
			for(i=0;i<preferences.length;i++){
				var listItem = document.createElement("li");
				var a = document.createElement("a");
				a.setAttribute("href", "javascript:recommend('"+preferences[i]+"')");
				a.innerHTML=preferences[i][1];
				listItem.appendChild(a);
				preferenceList.appendChild(listItem);
			}
		}		
		
		function getPreferences() {
			console.log("getPreferences()");
			var http = new XMLHttpRequest();

			http.onreadystatechange = function() {//Call a function when the state changes.
			    if (http.readyState == 4 && http.status == 200) {
			        console.log("Request complete with preferences", http.responseText);
			        drawPreferenceList(http.responseText);
			    }
			}
			http.open("GET", "getSavedLocations.php", true);
			http.send();
		}
		
		getPreferences();
	</script>	
</body>


<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
