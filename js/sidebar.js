var activeBusinessMarker;

function createPanel(businessData, businessType){
	
	var newOuterDiv = document.createElement('div')
	
	var heading = "Number of "+businessType+": "+businessData.length;
	var headingButton = document.createElement('button')
    headingButton.setAttribute('class','btn btn-info sidebarHeader');
	headingButton.setAttribute('type','button');
	headingButton.innerHTML = heading;
   	
	var collapseDiv = document.createElement('div')
	collapseDiv.setAttribute('id', businessType+"_collapse");
	 
	for(i = 0; i < businessData.length; i++){
		var businessDiv = document.createElement('div')
		
		businessDiv.addEventListener("mouseover", mouseOverPanel, false);
		businessDiv.addEventListener("mouseout", mouseOutPanel, false);
		
		businessDiv.innerHTML = businessData[i].name;
		console.log("businessData=", businessData[i]);
		businessDiv.setAttribute('data-info', JSON.stringify(businessData[i]));
		businessDiv.setAttribute('businessType', businessType);
		console.log("DIV = ", businessDiv);
		
		var innerDiv = document.createElement("div");
		businessDiv.appendChild(innerDiv);
		
		collapseDiv.appendChild(businessDiv);
   	}
    
	newOuterDiv.appendChild(headingButton);   
	newOuterDiv.appendChild(collapseDiv);    
	
    return newOuterDiv;
}

function createPanel2(businessData, businessType){
	
	var newOuterDiv = document.createElement('div')
    newOuterDiv.setAttribute('class','panel panel-default');
	
	var heading = "Number of "+businessType+": "+businessData.length;
	var headingButton = document.createElement('button')
    headingButton.setAttribute('class','btn btn-info');
	headingButton.setAttribute('type','button');
	headingButton.setAttribute('data-toggle','collapse');
	headingButton.setAttribute('data-target','#'+businessType+"_collapse");
	headingButton.innerHTML = heading;
   	
	var collapseDiv = document.createElement('div')
	collapseDiv.setAttribute('class','collapse in');
	collapseDiv.setAttribute('id', businessType+"_collapse");
	 
	for(i = 0; i < businessData.length; i++){
		var businessDiv = document.createElement('div')
		businessDiv.setAttribute('class','panel-body');
   		
		businessDiv.addEventListener("mouseover", mouseOverPanel, false);
		businessDiv.addEventListener("mouseout", mouseOutPanel, false);
		
		businessDiv.innerHTML = businessData[i].name;
		console.log("businessData=", businessData[i]);
		businessDiv.setAttribute('data-info', JSON.stringify(businessData[i]));
		businessDiv.setAttribute('businessType', businessType);
		console.log("DIV = ", businessDiv);
		collapseDiv.appendChild(businessDiv);
   	}
    
	newOuterDiv.appendChild(headingButton);   
	newOuterDiv.appendChild(collapseDiv);    
	
    return newOuterDiv;
}

function mouseOverPanel()
{  
	var data = JSON.parse(this.getAttribute("data-info"));
	console.log("MouseOver", this, data, data.latlng, data.name);
	
	var type = this.getAttribute('businessType');
	console.log("type=", type, this.dataType);
	
	if(activeBusinessMarker!=null) {
		activeBusinessMarker.setMap(null);
	}

	if(type!="primary schools" && type!="secondary schools"){
		console.log("id=", data.id);
		activeBusinessMarker = addMarker(data.geometry.location, data.name);
		activeBusinessMarker.setIcon('http://www.google.com/mapfiles/kml/paddle/grn-stars.png');
	}
	console.log("MOUSE OVER DONE");
	//var latlng = data.latlng.split(",");
	//console.log("latlng split=", latlng);
	//activeBusinessMarker = addMarker({lat:parseFloat(latlng[0]), lng:parseFloat(latlng[1])}, data.name);
	
	console.log("childrenNodes = ", this.childNodes);
	
	var d =  JSON.parse(this.getAttribute("data-info"));
	console.log("data", d);
	
	
	var inner = "";
	if(type=="primary schools"){
		inner = " - Address: "+d.address+"</br> - Active School Coordinator: "+d.activeSchoolCoordinator + "</br> - Associated Secondary School: "+d.associatedSecondarySchool+"</br> - Eco School Status: "+d.ecoSchoolStatus+" </br> - Email: "+d.email+" </br> - Head Teacher: "+d.headTeacher+"</br> - Meal Provider: "+d.mealProvider+"</br> - Website: "+d.website;
	}
	else if(type=="secondary schools"){
		inner = " - Address: "+d.address+"</br> - Active School Coordinator: "+d.activeSchoolCoordinator + "</br> - Eco School Status: "+d.ecoSchoolStatus+" </br> - Email: "+d.email+" </br> - Head Teacher: "+d.headTeacher+"</br> - Meal Provider: "+d.mealProvider+"</br> - Website: "+d.website;
	}
	else{
		inner = "-   address: "+d.vicinity
		if(d.rating!=null) inner+=" </br> -   rating: "+d.rating;
	}
	
	this.childNodes[1].innerHTML = inner;	
}



function callback(place, status) {
	console.log("CALLBACK", status, place);
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    console.log("place=",place);
	activeBusinessMarker = addMarker(place.geometry.location);
    console.log(place, activeBusinessMarker);
  }
  console.log("CALLBACK DONE");
}

function mouseOutPanel()
{  
	console.log("OUT");
	if(activeBusinessMarker!=null) {
		console.log("activeMarker =", activeBusinessMarker);
		activeBusinessMarker.setMap(null);
	}
	else console.log("NULL");
	activeBusinessMarker = null;
	
	this.childNodes[1].innerHTML = "";
}