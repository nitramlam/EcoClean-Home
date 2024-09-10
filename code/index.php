<?php
include 'header.php'; // Inclure le header
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoClean-Home</title>
    <link rel="stylesheet" href="index.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur EcoClean-Home</h1>
        <p>Découvrez des recettes maison pour créer des produits ménagers écologiques, économiques et simples à réaliser. Réduisez votre empreinte environnementale tout en prenant soin de votre maison !</p>

        <!-- Section des avantages -->
        <section class="benefits">
            <h2>Pourquoi choisir des produits ménagers maison ?</h2>
            <ul>
                <li>Écologique : Réduisez les déchets plastiques et les produits chimiques nocifs.</li>
                <li>Économique : Créez vos propres produits à partir d'ingrédients naturels à moindre coût.</li>
                <li>Simple : Des recettes faciles à suivre, avec des ingrédients que vous possédez déjà chez vous.</li>
            </ul>
        </section>

        <!-- Lien vers la page des ingrédients -->
        <div class="ingredients-link">
            <a href="ingredients.php" class="button">Voir la liste des ingrédients</a>
        </div>

        <!-- Section des catégories de recettes -->
        <section class="categories">
            <h2>Explorez nos catégories de recettes</h2>
            <div class="category-list">
                <a href="cuisine.php" class="category-item">Produits pour la cuisine</a>
                <a href="sdb.php" class="category-item">Produits pour la salle de bain</a>
                <a href="wc.php" class="category-item">Produits pour les WC</a>
            </div>
        </section>

       
    </div>
</body>
</html>
