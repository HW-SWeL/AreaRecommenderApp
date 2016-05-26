<?php
// ini_set("log_errors", 1);
// ini_set("error_log", "/tmp/php-error.log");

$filename = "/tmp/preferences.json";


$inputPreferenceText =  $_POST["preferenceText"];
$inputPreferenceName =  $_POST["preferenceName"];

$preference = array(
	'preferenceName' => $inputPreferenceName,
	'preferenceText' => $inputPreferenceText
);

if (file_exists($filename)) {
// 	error_log("addPreferenceProfile: File exists");
	$json = file_get_contents($filename);
	$data = json_decode($json);
	array_push($data, $preference);
	file_put_contents($filename, json_encode($data));
} else {
// 	error_log("addPreferenceProfile: File does not exist");
	$preferences[] = $preference;
	file_put_contents($filename, json_encode($preferences));
}

?>
