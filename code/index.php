<?php
// Connexion à la base de données
include 'db.php';

// Récupérer les catégories
$sql = "SELECT * FROM categorie";
$result = $conn->query($sql);

echo "<h1>Choisissez une catégorie :</h1>";
while ($row = $result->fetch_assoc()) {
    echo "<div><a href='categorie.php?categorie_id=" . $row['categorie_id'] . "'>" . $row['nom'] . "</a></div>";
}

$conn->close();
?>
