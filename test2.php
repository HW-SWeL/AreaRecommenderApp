<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Sortable - Default functionality</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link href="css/mainStyle.css" rel="stylesheet">
   
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZg5qfeNjn_F3H1XQfAPj1x6HUuIz6lPI&v=3.exp&signed_in=true&libraries=places"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  
  <!-- User defined functions -->
  <script type="text/javascript" src="js/map.js"></script> 
  <script type="text/javascript" src="js/service.js"></script> 
  <script type="text/javascript" src="js/sidebar.js"></script> 
  <script type="text/javascript" src="js/jquery.qtip.js"></script> 
 
  <title>Area Information App</title>
  
  	<?php 
		session_start(); 
		if($_SESSION['username']==null) header( 'Location: index.html' ) ;
	?>
  
</head>
<body>
 
<div class="couponcode">First Link
    <span class="coupontooltip">Content 1</span>
</div>

<div class="couponcode">Second Link
    <span class="coupontooltip"> Content 2</span>
</div>


</body>
</html>