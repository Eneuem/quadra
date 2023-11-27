<?php
$servername = "localhost";
$username = "root";
$password = "Quadrastream1!"; // Remplacez avec votre mot de passe de MySQL
$dbname = "test";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, nom, description FROM exemple";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Afficher les données de chaque ligne
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Nom: " . $row["nom"]. " - Description: " . $row["description"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
