<?php 

$servername = "localhost";
$targetname = "root";
$password = $_ENV['APP_ENV'];
$dbname = "ml_structure";



// Create connection
$conn = new mysqli($servername, $targetname, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$mysqli = new mysqli('localhost', 'root', $_ENV['APP_ENV'], 'ml_structure');


?>