function accessService_getLocationDataByName(name){	
	var d;
	
	$.get(
		"http://jbossews-jbdissertation.rhcloud.com/AppServlet",
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
        return $.ajax({url:"http://jbossews-jbdissertation.rhcloud.com/AppServlet",data:{request:"location", name:name}});
    },

	getLocationsSimple : function(name) {
		 return $.ajax({url:"http://jbossews-jbdissertation.rhcloud.com/AppServlet",data:{request:"locationsSimple"}});
	},
    
    recommend : function(preferenceJson){
    	return $.ajax({url:"http://jbossews-jbdissertation.rhcloud.com/AppServlet",data:{request:"recommend", preferences:preferenceJson}});
    }
};