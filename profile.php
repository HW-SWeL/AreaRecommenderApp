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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

	<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZg5qfeNjn_F3H1XQfAPj1x6HUuIz6lPI"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

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
	<script> 

		function getSavedLocations() {
			var http = new XMLHttpRequest();
			var url = "getSavedLocations.php";
			http.open("GET", url, true);

			http.onreadystatechange = function() {//Call a function when the state changes.
			    if(http.readyState == 4 && http.status == 200) {
			        var savedLocations = JSON.parse(http.responseText);
			        console.log("saved locations", savedLocations);
			        drawSavedLocations(savedLocations);
			    }
			}
			http.send();
		}

		function deletePreferences(pref) {
			var http = new XMLHttpRequest();
			var url = "deletePreferenceProfile.php";
			console.log("UNPARSE: ", pref);
			console.log("PARSE: ", pref.split(","), pref.split(",")[1]);
			var params = "id="+pref.split(",")[1];
			console.log("params", params);
			http.open("POST", url, true);
			

			//Send the proper header information along with the request
			http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			http.onreadystatechange = function() {//Call a function when the state changes.
			    if(http.readyState == 4 && http.status == 200) {
			        console.log("ret=", http.responseText);
			        alert("Preference profile deleted.");
			        getPreferences();
			    }
			}
			http.send(params);
		}

		function drawSavedLocations(savedLocations){
			var savedLocationDiv = document.getElementById("locationContainerInner");

			while(savedLocationDiv.hasChildNodes()) {
				savedLocationDiv.removeChild(savedLocationDiv.childNodes[0]);
			}
			
			var table = document.createElement("table");
			table.setAttribute("class", "table");
			
		 	var i;
			for(i=0;i<savedLocations.length;i++){
				var tbody = document.createElement("tbody");
				var td = document.createElement("td");
				td.innerHTML = savedLocations[i][1];
				tbody.appendChild(td);

				var tdButton = document.createElement("input");
				tdButton.setAttribute("type", "image");
				tdButton.setAttribute("src", "images/delete.jpg");
				tdButton.setAttribute("width", "20px");
				tdButton.setAttribute("height", "20px");
				tdButton.id = savedLocations[i][1];
				tdButton.setAttribute("onClick", "deleteLocationClicked(this.id);");
				tbody.appendChild(tdButton);

				var tdButton2 = document.createElement("input");
				tdButton2.setAttribute("type", "image");
				tdButton2.setAttribute("src", "images/goTo.jpg");
				tdButton2.setAttribute("width", "20px");
				tdButton2.setAttribute("height", "20px");
				tdButton2.id = savedLocations[i][1];
				tdButton2.setAttribute("onClick", "goToLocation(this.id);");
				tbody.appendChild(tdButton2);
				
				table.appendChild(tbody);
	  		}

	  		savedLocationDiv.appendChild(table);
		}

		function goToLocation(location){
			console.log("goto", location);

			var url = "index.php";
			var form = $('<form action="' + url + '" method="get">' +
			  '<input type="text" name="location" value="' + location + '" />' +
			  '</form>');
			$('body').append(form);
			form.submit();
		}

		function editPreference(json){
			console.log("editPreference", json);
			
			var url = "createPreference.php";
			var form = $("<form action='" + url + "' method='post'>" +
			  "<input type='text' name='json' value='" + json + "' />" +
			  "</form>");
			$('body').append(form);
			form.submit();
		}
		
		function deleteLocationClicked(location){
			console.log("clicked", location);

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
			        alert("Location has been deleted.");
			        getSavedLocations();
			    }
			}

			console.log("username=",username,"location=",location);
			xmlhttp.open("GET","deleteSavedLocation.php?username="+username+"&location="+location,true);
			xmlhttp.send();
		}

		

		function addPreferenceProfile(){
			window.location.href = "createPreference.php";
		}
		

		function drawAddButton(){
			var div = document.getElementById("preferenceContainer");
			
			var addButton = document.createElement("input");
			addButton.setAttribute("type", "image");
			addButton.setAttribute("src", "images/add.jpg");
			addButton.setAttribute("width", "20px");
			addButton.setAttribute("height", "20px");
			addButton.id="addButton";
			addButton.setAttribute("onClick", "addPreferenceProfile();");
			div.appendChild(addButton);
		}

		function deletePreferenceProfile(button){
			var json = button.parentNode.getAttribute("jsonData");
			console.log(json);
			deletePreferences(json);
		}

		function editPreferenceProfile(button){
			var json = button.parentNode.getAttribute("jsonData");

			editPreference(json);
		}
		
		function drawDeleteButton(element){			
			var deleteButton = document.createElement("input");
			deleteButton.setAttribute("type", "image");
			deleteButton.setAttribute("src", "images/delete.jpg");
			deleteButton.setAttribute("width", "20px");
			deleteButton.setAttribute("height", "20px");
			deleteButton.id="addButton";
			deleteButton.setAttribute("onClick", "deletePreferenceProfile(this);");
			element.appendChild(deleteButton);
		}

		function drawEditButton(element){			
			var editButton = document.createElement("input");
			editButton.setAttribute("type", "image");
			editButton.setAttribute("src", "images/edit.jpg");
			editButton.setAttribute("width", "40px");
			editButton.setAttribute("height", "20px");
			editButton.id="addButton";
			editButton.setAttribute("onClick", "editPreferenceProfile(this);");
			element.appendChild(editButton);
		}

		function drawPreferencePanels(json){
			var preferences = JSON.parse(json);
			console.log("json=", json, "preferences=", preferences);

			var preferenceDiv = document.getElementById("preferenceContainerInner");

			while(preferenceDiv.hasChildNodes()) {
				preferenceDiv.removeChild(preferenceDiv.childNodes[0]);
			}
			
			var i;
			for(i=0;i<preferences.length;i++){
				console.log(JSON.parse(preferences[i][2]));
				var div = document.createElement("div");
				div.setAttribute("jsonData", preferences[i]);
				div.setAttribute("class", "preferencePanel_profile");				
				var text = document.createElement("p");
				text.innerHTML = "Profile "+i+": "+preferences[i][3];
				div.appendChild(text);

				drawEditButton(div);				
				drawDeleteButton(div);
				
				preferenceDiv.appendChild(div);
			}
			
		}
		
		function getPreferences() {
			var http = new XMLHttpRequest();
			var url = "getSavedPreferences.php";
			http.open("GET", url, true);

			http.onreadystatechange = function() {//Call a function when the state changes.
			    if(http.readyState == 4 && http.status == 200) {
			        console.log("preferences", http.responseText);
			        drawPreferencePanels(http.responseText);
			    } else if (http.readyState == 4 && http.status != 200) {
				    console.log("Error retrieving preferences: ", http.responseText);
			    }
			}
			http.send();
		}

		getSavedLocations();
		getPreferences();
	 </script>
	

  <body>  
	  
	 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Area Information App</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="profile.php">Profile</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
        
   <div class="container">		
		<div class="well well-lg" id="mainContent">	
			<div id="preferenceContainer" class="col-md-8" >
				<h4>Preference Profiles</h4>
				<div id="preferenceContainerInner"></div>
			</div>
			
			<div  class="col-md-4" id="locationContainer" >
				<h4>Saved Locations</h4>
				<div id="locationContainerInner"></div>
			</div>
		</div>

   </div>
   
   <script>
		drawAddButton();
   </script>
</body>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
