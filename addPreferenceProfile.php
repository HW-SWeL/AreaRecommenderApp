<?php
$filename = 'preferences.json';

$inputPreferenceText =  $_POST["preferenceText"];
$inputPreferenceName =  $_POST["preferenceName"];

$preference = array(
	'preferenceName' => $inputPreferenceName,
	'preferenceText' => $inputPreferenceText
);

// read the file if present
$handle = @fopen($filename, 'r+');

// create the file if needed
if ($handle === null)
{
	$handle = fopen($filename, 'w+') or die("Unable to open file");
}

if ($handle)
{
	// seek to the end
	fseek($handle, 0, SEEK_END);

	// are we at the end of is the file empty
	if (ftell($handle) > 0)
	{
		// move back a byte
		fseek($handle, -1, SEEK_END);

		// add the trailing comma
		fwrite($handle, ',', 1);

		// add the new json string
		fwrite($handle, json_encode($preference) . ']');
	}
	else
	{
		// write the first event inside an array
		fwrite($handle, json_encode(array($preference)));
	}

	// close the handle on the file
	fclose($handle);
	var_dump(http_response_code(200));
	echo "success";
} else {
	die("Unable to open file");
}

?>
