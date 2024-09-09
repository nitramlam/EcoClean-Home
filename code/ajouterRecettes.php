<?php
include 'db.php';

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $categorie_id = $_POST['categorie'];

    // Insertion de la recette
    $sql = "INSERT INTO recette (nom, description, categorie_id) VALUES ('$nom', '$description', $categorie_id)";
    if ($conn->query($sql) === TRUE) {
        $recette_id = $conn->insert_id; // Récupérer l'ID de la nouvelle recette

        // Insertion des ingrédients
        foreach ($_POST['ingredients'] as $index => $ingredient) {
            $nom_ingredient = $ingredient['nom'];
            $quantite = $ingredient['quantite'];
            $unite_mesure = $ingredient['unite_mesure'];

            // Vérifier si l'ingrédient existe déjà
            $sql_ingredient = "SELECT * FROM ingredient WHERE nom = '$nom_ingredient'";
            $result = $conn->query($sql_ingredient);

            if ($result->num_rows > 0) {
                $ingredient_id = $result->fetch_assoc()['ingredient_id'];
            } else {
                // Si l'ingrédient n'existe pas, l'ajouter
                $sql_insert_ingredient = "INSERT INTO ingredient (nom) VALUES ('$nom_ingredient')";
                $conn->query($sql_insert_ingredient);
                $ingredient_id = $conn->insert_id;
            }

            // Associer l'ingrédient à la recette
            $sql_recette_ingredient = "INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite, unite_mesure) VALUES ($recette_id, $ingredient_id, $quantite, '$unite_mesure')";
            $conn->query($sql_recette_ingredient);
        }

        // Insertion des étapes
        foreach ($_POST['etapes'] as $ordre => $etape) {
            $description_etape = $etape['description'];
            $sql_etape = "INSERT INTO etape (recette_id, description, ordre) VALUES ($recette_id, '$description_etape', $ordre + 1)";
            $conn->query($sql_etape);
        }

        echo "Recette ajoutée avec succès !";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une recette</title>
</head>
<body>
    <h1>Ajouter une nouvelle recette</h1>

    <form action="ajouterRecettes.php" method="POST">
        <label for="nom">Nom de la recette :</label>
        <input type="text" name="nom" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>

        <label for="categorie">Catégorie :</label>
        <select name="categorie" required>
            <option value="1">Cuisine</option>
            <option value="2">Salle de bain</option>
            <option value="3">WC</option>
        </select><br>

        <h2>Ingrédients</h2>
        <div id="ingredients">
            <div class="ingredient">
                <label for="ingredient_nom">Nom de l'ingrédient :</label>
                <input type="text" name="ingredients[0][nom]" required>

                <label for="quantite">Quantité :</label>
                <input type="number" step="0.01" name="ingredients[0][quantite]" required>

                <label for="unite_mesure">Unité de mesure :</label>
                <input type="text" name="ingredients[0][unite_mesure]" required><br>
            </div>
        </div>
        <button type="button" onclick="ajouterIngredient()">Ajouter un autre ingrédient</button><br>

        <h2>Étapes</h2>
        <div id="etapes">
            <div class="etape">
                <label for="etape_description">Description de l'étape :</label>
                <input type="text" name="etapes[0][description]" required><br>
            </div>
        </div>
        <button type="button" onclick="ajouterEtape()">Ajouter une autre étape</button><br>

        <input type="submit" value="Ajouter la recette">
    </form>

    <script>
        let ingredientIndex = 1;
        let etapeIndex = 1;

        function ajouterIngredient() {
            const ingredientsDiv = document.getElementById('ingredients');
            const newIngredient = `
                <div class="ingredient">
                    <label for="ingredient_nom">Nom de l'ingrédient :</label>
                    <input type="text" name="ingredients[${ingredientIndex}][nom]" required>

                    <label for="quantite">Quantité :</label>
                    <input type="number" step="0.01" name="ingredients[${ingredientIndex}][quantite]" required>

                    <label for="unite_mesure">Unité de mesure :</label>
                    <input type="text" name="ingredients[${ingredientIndex}][unite_mesure]" required><br>
                </div>
            `;
            ingredientsDiv.insertAdjacentHTML('beforeend', newIngredient);
            ingredientIndex++;
        }

        function ajouterEtape() {
            const etapesDiv = document.getElementById('etapes');
            const newEtape = `
                <div class="etape">
                    <label for="etape_description">Description de l'étape :</label>
                    <input type="text" name="etapes[${etapeIndex}][description]" required><br>
                </div>
            `;
            etapesDiv.insertAdjacentHTML('beforeend', newEtape);
            etapeIndex++;
        }
    </script>
</body>
</html>
