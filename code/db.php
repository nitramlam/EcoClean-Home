<?php
$servername = "mysql-db-v2";  
$username = "NitramEcoClean";  
$password = "456123Eco!";  
$dbname = "home_cleaning_recipes";  

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>