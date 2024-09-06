<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une recette</title>
</head>
<body>
    <h1>Ajouter une nouvelle recette</h1>
    <form action="traiter_recette.php" method="POST">
        <label for="nom">Nom de la recette :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="categorie">Catégorie :</label>
        <input type="text" id="categorie" name="categorie"><br><br>

        <label for="image_path">Chemin de l'image :</label>
        <input type="
