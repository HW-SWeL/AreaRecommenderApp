<?php

$inputUsername =  $_GET["username"];

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
$conn = mysql_connect($dbhost.':'.$dbport, $dbusername, $dbpassword);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
$sql = 'SELECT * FROM users WHERE username="'.$inputUsername.'"';

mysql_select_db('dissertationdb');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}

$num_rows = mysql_num_rows($retval);

mysql_free_result($retval);
mysql_close($conn);

if($num_rows > 0) echo "true";
else echo "false";

//header( 'Location: index.html' );

?>

