<?php
	
$servername = "db";
$username =   "devuser";       //"username";
$password =   "devpass";         //"password";
$dbname =      "test_db";     //'databasename';


  // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

  // Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//echo 'Sucessfully connected to mysql';

?>