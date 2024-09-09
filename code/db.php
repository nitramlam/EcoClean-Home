<?php
// Paramètres de connexion à la base de données
$servername = "db";  // Utilise le nom du service MySQL dans Docker (qui est 'db')
$username = "root";  // Utilisateur MySQL
$password = "root_password";  // Mot de passe MySQL
$dbname = "home_cleaning_recipes";  // Nom de la base de données

// Créer la connexion à MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");
// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

?>
