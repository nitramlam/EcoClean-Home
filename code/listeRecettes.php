<?php
include 'db.php';

$sql = "SELECT * FROM recette";
$result = $conn->query($sql);

echo "<h1>Liste des recettes</h1>";
while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h2>" . $row['nom'] . "</h2>";
    echo "<a href='modifier_recette.php?recette_id=" . $row['recette_id'] . "'>Modifier</a> | ";
    echo "<a href='supprimer_recette.php?recette_id=" . $row['recette_id'] . "'>Supprimer</a>";
    echo "</div><hr>";
}

$conn->close();
?>
