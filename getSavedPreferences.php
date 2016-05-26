<?php
// ini_set("log_errors", 1);
// ini_set("error_log", "/tmp/php-error.log");

$filename = "/tmp/preferences.json";


// create the file if needed
if (file_exists($filename))
{
// 	error_log("File exists");
	// File is stored as json so no need to decode to only then encode it to send over the wire
	$json = file_get_contents($filename);
	echo ($json);	
} else {
// 	error_log("File does not exist");
	// Send preference back as a json object (translated back from array or arrays)
	//echo json_encode($rows);
	$preferences = array();
	echo json_encode($preferences);
}

?>


