<?php
	
$servername = "db";
$username =   "bruker";       //"username";
$password =   "passord";         //"password";
$dbname =      "DEV_DB";     //'databasename';


  // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

  // Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//echo 'Sucessfully connected to mysql';

?>