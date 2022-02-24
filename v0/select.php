<?php 

$servername = "localhost";
$targetname = "root";
$password = "";
$dbname = "ml_structure";



// Create connection
$conn = new mysqli($servername, $targetname, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$mysqli = new mysqli('localhost', 'root', '', 'ml_structure');


$getSentence = $_GET['sentence'];



$familySentence = substr_count($getSentence, " ") + 1;

$target = $getSentence;
$sql = "SELECT * FROM `snapshot` WHERE `structure` = '{$target}'"; //monto a query


$query = $mysqli->query( $sql ); //executo a query

if( $query->num_rows > 0 ) {//se retornar algum resultado

  // Seleciona ID que foi encontrado
    $sql = "SELECT id, structure, ocorrencies, family FROM snapshot";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        // Atualiza registro de id encontrado
            $idEncontrado = $row["id"];
            $ocorrencies = $row["ocorrencies"] + 1;
            
            // Se o id for o mesmo que o alvo encontrado
            if ($row["structure"] == $target) {
                $sql = "UPDATE snapshot SET ocorrencies=$ocorrencies WHERE id=$idEncontrado";
                if ($conn->query($sql) === TRUE) {
                  echo "Record updated successfully";
                } else {
                  echo "Error updating record: " . $conn->error;
                }
            }
        // fim de atualização
      }
    }
  
} else {
        $sql = "INSERT INTO snapshot (structure, ocorrencies, family)
        VALUES (\"$target\", 1, $familySentence)";

        if ($conn->query($sql) === TRUE) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
}

$conn->close();

?>