<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ml_structure";

$getSentence = $_GET['sentence'];
$familySentence = substr_count($getSentence, " ") + 1;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$mysqli = new mysqli('localhost', 'root', '', 'ml_structure');

$user = 'how are dumb';
$sql = "SELECT * FROM `snapshot` WHERE `structure` = '{$user}'"; //monto a query


$query = $mysqli->query( $sql ); //executo a query

if( $query->num_rows > 0 ) {//se retornar algum resultado
  echo 'Já existe!';
} else {
  echo 'Não existe ainda!';
}

$conn->close();

?>