<?php
// Inclure la connexion à la base de données
include 'db.php';

// Requête SQL pour récupérer toutes les recettes
$sql = "SELECT * FROM recette";
$result = $conn->query($sql);

// Afficher les recettes
if ($result->num_rows > 0) {
    echo "<h1>Liste des recettes</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>" . $row["nom"] . "</h2>";
        echo "<p>" . $row["description"] . "</p>";
        echo "<img src='" . $row["image_path"] . "' alt='" . $row["nom"] . "'>";
        echo "</div><hr>";
    }
} else {
    echo "Aucune recette trouvée.";
}

// Fermer la connexion
$conn->close();
?>
