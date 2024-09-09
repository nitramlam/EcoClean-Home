<?php
include 'db.php';

// Ajouter une recette
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter_recette'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $categorie_id = $_POST['categorie'];

    // Insertion de la recette
    $sql = "INSERT INTO recette (nom, description, categorie_id) VALUES ('$nom', '$description', $categorie_id)";
    if ($conn->query($sql) === TRUE) {
        $recette_id = $conn->insert_id; // Récupérer l'ID de la nouvelle recette

        // Insertion des ingrédients associés à la recette
        foreach ($_POST['ingredients'] as $index => $ingredient_id) {
            $quantite = $_POST['quantites'][$index];
            $unite_mesure = $_POST['unites_mesure'][$index];

            // Associer l'ingrédient à la recette
            $sql_recette_ingredient = "INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite, unite_mesure) VALUES ($recette_id, $ingredient_id, $quantite, '$unite_mesure')";
            $conn->query($sql_recette_ingredient);
        }

        // Insertion des étapes
        foreach ($_POST['etapes'] as $ordre => $etape_description) {
            $sql_etape = "INSERT INTO etape (recette_id, description, ordre) VALUES ($recette_id, '$etape_description', $ordre + 1)";
            $conn->query($sql_etape);
        }

        echo "Recette ajoutée avec succès !";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

// Récupérer tous les ingrédients
$sql_ingredients = "SELECT * FROM ingredient";
$result_ingredients = $conn->query($sql_ingredients);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une nouvelle recette</title>
</head>
<body>
    <h1>Ajouter une nouvelle recette</h1>

    <form action="ajouter_recette.php" method="POST">
        <label for="nom">Nom de la recette :</label>
        <input type="text" name="nom" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>

        <!-- Sélection de la catégorie -->
        <label for="categorie">Catégorie :</label>
        <select name="categorie" required>
            <option value="1">Cuisine</option>
            <option value="2">Salle de bain</option>
            <option value="3">WC</option>
        </select><br>

        <h2>Ingrédients</h2>
        <div id="ingredients">
            <div class="ingredient">
                <label for="ingredient_id">Ingrédient :</label>
                <select name="ingredients[]" required>
                    <?php while ($row = $result_ingredients->fetch_assoc()) { ?>
                        <option value="<?php echo $row['ingredient_id']; ?>"><?php echo $row['nom']; ?></option>
                    <?php } ?>
                </select>

                <label for="quantite">Quantité :</label>
                <input type="number" step="0.01" name="quantites[]" required>

                <label for="unite_mesure">Unité de mesure :</label>
                <input type="text" name="unites_mesure[]" required><br>
            </div>
        </div>
        <button type="button" onclick="ajouterIngredient()">Ajouter un autre ingrédient</button><br>

        <h2>Étapes</h2>
        <div id="etapes">
            <div class="etape">
                <label for="etape_description">Description de l'étape :</label>
                <input type="text" name="etapes[]" required><br>
            </div>
        </div>
        <button type="button" onclick="ajouterEtape()">Ajouter une autre étape</button><br>

        <input type="submit" name="ajouter_recette" value="Ajouter la recette">
    </form>

    <script>
        let ingredientIndex = 1;
        let etapeIndex = 1;

        function ajouterIngredient() {
            const ingredientsDiv = document.getElementById('ingredients');
            const newIngredient = `
                <div class="ingredient">
                    <label for="ingredient_id">Ingrédient :</label>
                    <select name="ingredients[]" required>
                        <?php
                        // Récupérer les ingrédients à chaque ajout
                        $result_ingredients = $conn->query($sql_ingredients);
                        while ($row = $result_ingredients->fetch_assoc()) { ?>
                            <option value="<?php echo $row['ingredient_id']; ?>"><?php echo $row['nom']; ?></option>
                        <?php } ?>
                    </select>

                    <label for="quantite">Quantité :</label>
                    <input type="number" step="0.01" name="quantites[]" required>

                    <label for="unite_mesure">Unité de mesure :</label>
                    <input type="text" name="unites_mesure[]" required><br>
                </div>
            `;
            ingredientsDiv.insertAdjacentHTML('beforeend', newIngredient);
        }

        function ajouterEtape() {
            const etapesDiv = document.getElementById('etapes');
            const newEtape = `
                <div class="etape">
                    <label for="etape_description">Description de l'étape :</label>
                    <input type="text" name="etapes[]" required><br>
                </div>
            `;
            etapesDiv.insertAdjacentHTML('beforeend', newEtape);
        }
    </script>
</body>
</html>
