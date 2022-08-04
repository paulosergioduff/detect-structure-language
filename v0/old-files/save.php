<?php 

$servername = "localhost";
$username = "root";
$password = "TR4vcijU6T9Keaw";
$dbname = "ml_structure";

$getSentence = $_GET['sentence'];
$getOcorrencies = $_GET['ocorrencies'];
$familySentence = substr_count($getSentence, " ") + 1;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO snapshot (structure, ocorrencies, family)
VALUES (\"$getSentence\", $getOcorrencies, $familySentence)";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>