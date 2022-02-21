<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ml_structure";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO snapshot (structure, ocorrencies, family)
VALUES ('how are dumb', 10, 3)";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>