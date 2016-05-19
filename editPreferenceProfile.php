<?php

$inputUsername =  $_POST["username"];
$inputPreferenceText =  $_POST["preferenceText"];
$inputPreferenceName =  $_POST["preferenceName"];
$inputId =  $_POST["id"];

define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME', getenv('OPENSHIFT_GEAR_NAME'));

$dbhost = constant("DB_HOST"); // Host name 
$dbport = constant("DB_PORT"); // Host port
$dbusername = constant("DB_USER"); // Mysql username 
$dbpassword = constant("DB_PASS"); // Mysql password 

// Create connection
$conn = new mysqli($dbhost.":".$dbport, $dbusername, $dbpassword, "dissertationdb");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE user_preferences SET username='".$inputUsername."', preference_text='".$inputPreferenceText."', name='".$inputPreferenceName."' WHERE preference_id=".$inputId;


if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
   echo "Error: " . $sql . "<br>" . $conn->error;
}

//$conn->close();

?>
