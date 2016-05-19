<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Create a Preference Profile</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link href="css/mainStyle.css" rel="stylesheet">
   
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZg5qfeNjn_F3H1XQfAPj1x6HUuIz6lPI&v=3.exp&signed_in=true&libraries=places"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  
  <!-- User defined functions -->
  <script type="text/javascript" src="js/map.js"></script> 
  <script type="text/javascript" src="js/service.js"></script> 
  <script type="text/javascript" src="js/sidebar.js"></script> 
 
  <title>Area Information App</title>
  
  	<?php 
		session_start(); 
		if($_SESSION['username']==null) header( 'Location: index.html' ) ;
	?>
  
</head>
<body>
	<script>
	var geocoder = new google.maps.Geocoder();
	
		var username = '<?php echo $_SESSION["username"]; ?>';
		console.log("username=", username);

		var json = '<?php echo $_POST["json"]; ?>';
		console.log("json", json);
		var id;

		function fillEdit(json){
			var data =  json.split(",");
			console.log(data);

			document.getElementById("preferenceName").value = data[data.length-1];

			id=data[1];
			console.log("id=", id);
			
			var d1 = data;
			d1.splice(0,2);
			d1.pop();
			console.log(d1);
			var prefs = JSON.parse(d1);
			var i;
			for(i=0;i<prefs.length;i++){
				console.log("pref", i, prefs[i]);
				if(prefs[i].type=="LocationDistance"){
					var div = addLocationDistance();
					console.log(div);
					var children = div.childNodes;
					children[1].value=prefs[i].location;
					children[4].value = prefs[i].distance
				}
				else if(prefs[i].type=="LocationTime"){
					var div = addLocationTime();
					console.log(div);
					var children = div.childNodes;
					children[1].value=prefs[i].location;
					children[4].value=prefs[i].timeInMinutes;

					var transportType = prefs[i].transportType;
					if(transportType=="Car") children[6].selectedIndex=0;	
					else if(transportType=="Public") children[6].selectedIndex=1;	
					else if(transportType=="Walk") children[6].selectedIndex=2;	
					else if(transportType=="Cycle") children[6].selectedIndex=3;					
				}
				else if(prefs[i].type=="TypeDistance"){
					var div = addTypeDistance();
					console.log(div);
					var children = div.childNodes;

					var locType = prefs[i].locationType;
					if(locType=="Grocery") children[1].selectedIndex=0;	
					else if(locType=="Cafe") children[1].selectedIndex=1;	
					else if(locType=="Entertainment") children[1].selectedIndex=2;	
					else if(locType=="Primary School") children[1].selectedIndex=3;	
					else if(locType=="Secondary School") children[1].selectedIndex=4;	

					children[4].value = prefs[i].distance
					
				}
				else if(prefs[i].type=="TypeTime"){
					var div = addTypeTime();
					console.log(div);
					var children = div.childNodes;

					var locType = prefs[i].locationType;
					if(locType=="Grocery") children[1].selectedIndex=0;	
					else if(locType=="Cafe") children[1].selectedIndex=1;	
					else if(locType=="Entertainment") children[1].selectedIndex=2;	
					else if(locType=="Primary School") children[1].selectedIndex=3;	
					else if(locType=="Secondary School") children[1].selectedIndex=4;	
					
					children[4].value=prefs[i].timeInMinutes;
					
					var transportType = prefs[i].transportType;
					if(transportType=="Car") children[6].selectedIndex=0;	
					else if(transportType=="Public") children[6].selectedIndex=1;	
					else if(transportType=="Walk") children[6].selectedIndex=2;	
					else if(transportType=="Cycle") children[6].selectedIndex=3;	
				}
			}
		}
		
		function drawDeleteButton(div){
			var tdButton = document.createElement("input");
			tdButton.setAttribute("type", "image");
			tdButton.setAttribute("src", "images/delete.jpg");
			tdButton.setAttribute("width", "20px");
			tdButton.setAttribute("height", "20px");
			tdButton.id = "deleteButton";
			tdButton.setAttribute("onClick", "deletePref(this);");
			div.appendChild(tdButton);
		}
	
		function drawType(div){
			var typeLabel = document.createElement("label");
			typeLabel.innerHTML="Type: ";
			div.appendChild(typeLabel);
			
			var select = document.createElement("select");
	
			var types = ["Grocery", "Cafe", "Entertainment", "Primary School", "Secondary School"];
			var i;
			for(i=0;i<types.length;i++){
				var option = document.createElement("option");
				option.setAttribute("value", types[i]);
				option.innerHTML = types[i];
				select.appendChild(option);
			}
			div.appendChild(select);
		}
	
		function drawDistance(div){
			var withinLabel = document.createElement("label");
			withinLabel.innerHTML="Within (metres): ";
			div.appendChild(withinLabel);
	
			var input = document.createElement("input");
			input.setAttribute("type", "text");
			input.setAttribute("name", "distance");
			input.setAttribute("size", 15);
			div.appendChild(input);
		}	

		function drawTime(div){
			var typeLabel = document.createElement("label");
			typeLabel.innerHTML="Within (mins): ";
			div.appendChild(typeLabel);

			var input = document.createElement("input");
			input.setAttribute("type", "text");
			input.setAttribute("name", "mins");
			input.setAttribute("size", "5");
			div.appendChild(input);

			var typeLabel = document.createElement("label");
			typeLabel.innerHTML="By: ";
			div.appendChild(typeLabel);
			
			var select = document.createElement("select");
	
			var types = ["Car", "Public", "Walk", "Cycle"];
			var i;
			for(i=0;i<types.length;i++){
				var option = document.createElement("option");
				option.setAttribute("value", types[i]);
				option.innerHTML = types[i];
				select.appendChild(option);
			}
			div.appendChild(select);
		}
		
		function drawLocation(div){
			var locationLabel = document.createElement("label");
			locationLabel.innerHTML="Location: ";
			div.appendChild(locationLabel);
	
			var input = document.createElement("input");
			input.setAttribute("type", "text");
			input.setAttribute("name", "address");
			div.appendChild(input);
		}
		
		function addLocationDistance(latlng, location){
			console.log("added preference for ", latlng);

			var divOuter = document.getElementById("preferenceListDiv");

			var div = document.createElement("div");
			div.setAttribute("class", "well span2 tile");
			div.setAttribute("dataType", "locationDistance");
			
			drawLocation(div);

			var br = document.createElement("br");
			div.appendChild(br);

			drawDistance(div);

			drawDeleteButton(div);
			
			divOuter.appendChild(div);

			if(location!=null){
				console.log(location);
			}

			return div;
		}

		function addLocationTime(latlng){
			console.log("added preference for ", latlng);

			var divOuter = document.getElementById("preferenceListDiv");

			var div = document.createElement("div");
			div.setAttribute("class", "well span2 tile");
			div.setAttribute("dataType", "locationTime");
			
			drawLocation(div);

			var br = document.createElement("br");
			div.appendChild(br);

			drawTime(div);

			drawDeleteButton(div);

			divOuter.appendChild(div);

			return div;
		}

		function addTypeDistance(){
			console.log("added");

			var divOuter = document.getElementById("preferenceListDiv");

			var div = document.createElement("div");
			div.setAttribute("class", "well span2 tile");
			div.setAttribute("dataType", "typeDistance");
			
			drawType(div);

			var br = document.createElement("br");
			div.appendChild(br);

			drawDistance(div);

			drawDeleteButton(div);

			divOuter.appendChild(div);

			return div;
		}

		function addTypeTime(){
			console.log("added");

			var divOuter = document.getElementById("preferenceListDiv");

			var div = document.createElement("div");
			div.setAttribute("class", "well span2 tile");
			div.setAttribute("dataType", "typeTime");
			
			drawType(div);

			var br = document.createElement("br");
			div.appendChild(br);

			drawTime(div);

			drawDeleteButton(div);

			divOuter.appendChild(div);

			return div;
		}
		
		function drawAddButton(){
			var div = document.getElementById("preferenceListDiv");
			
			var addButton = document.createElement("input");
			addButton.setAttribute("type", "image");
			addButton.setAttribute("src", "images/add.jpg");
			addButton.setAttribute("width", "20px");
			addButton.setAttribute("height", "20px");
			addButton.id="addButton";
			addButton.setAttribute("onClick", "addTypePreference();");
			div.appendChild(addButton);
		}

		function convertStringToLatLng(location, element){
			geocoder.geocode( { 'address': location, 'componentRestrictions':{'country':'GB'}}, function(results, status) {
				console.log(results, status);
		      if (status == google.maps.GeocoderStatus.OK) {
			      console.log("results=", results);		
			      element.value = results[0].geometry.location.k+","+results[0].geometry.location.D;
			      return true;						         
		      } else {
			    	alert("Cannot find entered location.");
		        	console.log("Geocode was not successful for the following reason: " + status);
		        	return false;
		      }
		    });
		}
		
		function validatePrefs(){
			var list = document.getElementById("preferenceListDiv").childNodes;
			console.log("validating=", list);

			var i=0;
			for(i=0;i<list.length;i++){
				console.log(list[i]);

				var children = list[i].children;
				
				if(list[i].getAttribute("dataType")=="locationDistance"){    		
	        		if(children[4].value=="" || isNaN(children[4].value)) return false;
	        		if(children[1].value=="") return false;
	        		if(convertStringToLatLng(children[1].value, children[1]))return false;
	        	}
	        	else if(list[i].getAttribute("dataType")=="locationTime"){
	        		if(children[4].value=="" || isNaN(children[4].value)) return false;
	        		if(children[1].value=="") return false;
	        		if(convertStringToLatLng(children[1].value, children[1])) return false;
	        	}
	        	else if(list[i].getAttribute("dataType")=="typeDistance"){
	        		if(children[4].value=="" || isNaN(children[4].value)) return false;
	        	}
	        	else if(list[i].getAttribute("dataType")=="typeTime"){
	        		if(children[4].value=="" || isNaN(children[4].value)) return false;
	        	}			
				
			}			
			
			return true;
		}

		function savePref(){
			if(validatePrefs()){
				var newProfile;
				if(jsonBACK==null || jsonBACK==""){
					newProfile=true;
					console.log("A");
				}
				else {
					newProfile=false;
					console.log("B");
				}
				console.log("json=", json, "newProfile", newProfile, "jsonBACK=", jsonBACK);
				
				var list = document.getElementById("preferenceListDiv").childNodes;
				console.log("list=", list);
	
				var jsonArray = [];
				
				var i;
				for(i=0;i<list.length;i++){
					console.log(i, list[i]);
					var obj = new Object();
					
					var children = list[i].children;
					console.log("children=", children);		
							
					if(list[i].getAttribute("dataType")=="locationDistance"){
		        		obj.type= "LocationDistance";       		
		        		obj.distance = children[4].value;
		        		obj.location = children[1].value;
		        	}
		        	else if(list[i].getAttribute("dataType")=="locationTime"){
		        		obj.type= "LocationTime";
		        		obj.timeInMinutes= children[4].value;
		        		obj.transportType= children[6].options[children[6].selectedIndex].text;
		        		obj.location= children[1].value;
		        	}
		        	else if(list[i].getAttribute("dataType")=="typeDistance"){
		        		obj.type= "TypeDistance";
		        		obj.distance = children[4].value;
		        		obj.locationType = children[1].options[children[1].selectedIndex].text;
		        	}
		        	else if(list[i].getAttribute("dataType")=="typeTime"){
		        		obj.type="TypeTime";
		        		obj.timeInMinutes = children[4].value;
		        		obj.transportType= children[6].options[children[6].selectedIndex].text;
		        		obj.locationType= children[1].options[children[1].selectedIndex].text;
		        	}				
					
					jsonArray[i]=obj;
				}
	
				var json = JSON.stringify(jsonArray);
	
				if(newProfile){
					console.log("Saved", JSON.parse(json), json);			
					var http = new XMLHttpRequest();
					var url = "addPreferenceProfile.php";
					var params = "username="+username+"&preferenceText="+json+"&preferenceName="+document.getElementById("preferenceName").value;
					http.open("POST", url, true);
		
					//Send the proper header information along with the request
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
					http.onreadystatechange = function() {//Call a function when the state changes.
					    if(http.readyState == 4 && http.status == 200) {
					        console.log("response", http.responseText);
					        alert("Preference Profile Created");
					        window.location.href = "profile.php";
					    }
					}
					http.send(params);
				}
				else{
					console.log("Edited", JSON.parse(json), json);			
					var http = new XMLHttpRequest();
					var url = "editPreferenceProfile.php";
					console.log("ID==", id);
					var params = "username="+username+"&preferenceText="+json+"&id="+id+"&preferenceName="+document.getElementById("preferenceName").value;
					http.open("POST", url, true);
		
					//Send the proper header information along with the request
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
					http.onreadystatechange = function() {//Call a function when the state changes.
					    if(http.readyState == 4 && http.status == 200) {
					        console.log("response", http.responseText);
					        alert("Preference Profile Edited");
					        window.location.href = "profile.php";
					    }
					}
					http.send(params);
				}
			}
			else alert("Invalid input.");
		}

		function deletePref(item){
			console.log(item, item.parentNode);
			var parent = item.parentNode;
			parent.parentNode.removeChild(parent);
		}
		
	</script>	

<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="map.php">Area Information App</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav"> 
            <li><a href="profile.php">Profile</a></li>
          	<li><a href="index.html">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <div class="container">			
		<div class="well well-lg" id="mainContent">
			
			<div id="mapContainer" class="col-md-8" >
				  <div class="col-lg-6">
					<div class="input-group">
					  <input type="text" class="form-control" placeholder="Search for...">
					  <span class="input-group-btn">
						<button class="btn btn-default" type="button">Go!</button>
					  </span>
					</div><!-- /input-group -->
				  </div><!-- /.col-lg-6 -->
			</div>

			<div  class="col-md-4 panel-group container" id="sidebar">
				<div>
					<h4>Name: </h4><input type="text" name="preferenceName" id="preferenceName"><br>
					<button class="btn btn-default" onclick="addLocationDistance();" type="button">LocationDistance</button>
					<button class="btn btn-default" onclick="addLocationTime();" type="button">LocationTime</button>
					</br>
					<button class="btn btn-default" onclick="addTypeDistance();" type="button">TypeDistance</button>
					<button class="btn btn-default" onclick="addTypeTime();" type="button">TypeTime</button>
						<div id="preferenceListDiv" class="row grid span8"></div>
						<button class="btn btn-default" onclick="savePref();" type="button">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
 
 	<script>
	 	$(function () {
	 	    $(".grid").sortable({
	 	        tolerance: 'pointer',
	 	        revert: 'invalid',
	 	        placeholder: 'span2 well placeholder tile',
	 	        forceHelperSize: true
	 	    });
	 	});
	
		initMap("mapContainer", 55.953252000000000000, -3.188266999999996000);
	
		google.maps.event.addListener(map, 'click', function(event) {
			var latlng = event.latLng;
		    addLocationPreference({"lat":latlng.k, "lng":latlng.D});
	
		    //create location pref
			
		});
		
		$('.dropdown-toggle').dropdown();

		var jsonBACK = json;
		if(json!=null && json!=""){
			fillEdit(json);
			
		}
 	</script>
 
</body>
</html>