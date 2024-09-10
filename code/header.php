<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <header>
        <div class="site-logo">
            <a href="index.php" style="color: white; text-decoration: none;">EcoClean-Home</a> 
        </div>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="cuisine.php">Cuisine</a></li> 
                <li class="nav-item"><a href="sdb.php">Salle de bain</a></li> 
                <li class="nav-item"><a href="wc.php">WC</a></li> 
                <li class="nav-item"><a href="gestion_ingredients.php">Ajouter ingrédient</a></li> 
                <li class="nav-item"><a href="gestion_recettes.php">Ajouter recette</a></li> 
            </ul>
        </nav>
    </header>
</body>
</html>
