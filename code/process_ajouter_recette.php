<?php
include 'db.php';  // Inclure la connexion à la base de données

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$description = $_POST['description'];
$categorie = $_POST['categorie'];
$image_path = $_POST['image_path'];

// Préparer et exécuter la requête pour insérer la recette
$sql = "INSERT INTO recette (nom, description, categorie, image_path) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nom, $description, $categorie, $image_path);

if ($stmt->execute()) {
    echo "Recette ajoutée avec succès.";
} else {
    echo "Erreur lors de l'ajout de la recette : " . $conn->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
