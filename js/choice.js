function areaNameSubmit(areaName){
	webService.getLocationsSimple().done(function(data){
		var locations = JSON.parse(data);
		console.log(locations);

		for(var i=0; i<locations.length;i++){
			console.log(locations[i].name, areaName, typeof locations[i].name);
			
			if(locations[i].name===areaName){
				console.log("MATCH");
			    var form = document.createElement("form");
			    form.setAttribute("method", "post");
			    form.setAttribute("action", "map.php");

	            var hiddenField = document.createElement("input");
	            hiddenField.setAttribute("type", "hidden");
	            hiddenField.setAttribute("name", "areaNameInput");
	            hiddenField.setAttribute("value", areaName);

	            form.appendChild(hiddenField);

			    document.body.appendChild(form);
			    form.submit();
			}
		}
	});
}
