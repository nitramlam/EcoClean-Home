<?php
$servername = "db";
$username = "root";
$password = "root_password";
$dbname = "home_cleaning_recipes";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

$sql = "INSERT INTO recette (nom, description, categorie, image_path) VALUES ('Lessive écologique', 'Recette test pour encodage', 'Test', 'images/test.png')";

if ($conn->query($sql) === TRUE) {
    echo "Donnée insérée avec succès";
} else {
    echo "Erreur: " . $conn->error;
}

$conn->close();
?>
