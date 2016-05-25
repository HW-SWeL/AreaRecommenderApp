var recommenderService = "http://localhost:8080/AreaRecommenderService/AppServlet"; 

function accessService_getLocationDataByName(name){	
	var d;
	
	$.get(
		recommenderService,
		{ request : "location",
		  name : name
		},
		function(data) {
			d=data;
			alert(data);
			alert(d);
		}
	);
	
	
	alert(d);
}


var webService = {
    getLocationByName: function (name) {
        return $.ajax({
        	url:recommenderService,
        	data: {request:"location", name:name}}
        );
    },

	getLocationsSimple : function(name) {
		 return $.ajax({url:recommenderService,data:{request:"locationsSimple"}});
	},
    
    recommend : function(preferenceJson){
    	return $.ajax({url:recommenderService,data:{request:"recommend", preferences:preferenceJson}});
    }
};