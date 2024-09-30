<?php
include 'db.php';  // Fichier de connexion à la base de données

// Définir le nom d'utilisateur et le mot de passe
$username = 'adminClean33'; // Nom d'utilisateur unique
$password = 'Cleaning!Home33'; // Remplace par ton mot de passe

// Hachage du mot de passe
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertion de l'utilisateur avec le mot de passe haché
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "Utilisateur créé avec succès.";
} else {
    echo "Erreur lors de la création de l'utilisateur : " . $conn->error;
}

$stmt->close();
$conn->close();
?>