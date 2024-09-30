<?php

$servername = "sql103.infinityfree.com";  // Le nom d'hôte MySQL depuis InfinityFree
$username = "if0_37289998";  // Le nom d'utilisateur MySQL fourni par InfinityFree
$password = "456123Fx37";  // Le mot de passe MySQL fourni par InfinityFree (obtenu dans le panneau)
$dbname = "if0_37289998_ecoclean";  // Le nom de la base de données MySQL sur InfinityFree


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");  


if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>
