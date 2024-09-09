<?php
include 'db.php';

// Ajouter ou modifier une recette
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recette_id = $_POST['recette_id'] ?? null;  // Récupérer l'ID de la recette si elle existe

    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $etapes = $_POST['etapes'];
    $categorie_id = $_POST['categorie'];

    if ($recette_id) {
        // Modification de la recette
        $sql = "UPDATE recette SET nom = '$nom', description = '$description', etapes = '$etapes', categorie_id = $categorie_id WHERE recette_id = $recette_id";
        if ($conn->query($sql) === TRUE) {
            // Supprimer les anciens ingrédients associés à la recette
            $conn->query("DELETE FROM recette_ingredient WHERE recette_id = $recette_id");

            // Réinsertion des ingrédients associés à la recette
            foreach ($_POST['ingredients'] as $index => $ingredient_id) {
                $quantite = $_POST['quantites'][$index];
                $unite_mesure = $_POST['unites_mesure'][$index];
                $sql_recette_ingredient = "INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite, unite_mesure) VALUES ($recette_id, $ingredient_id, $quantite, '$unite_mesure')";
                $conn->query($sql_recette_ingredient);
            }
            echo "Recette modifiée avec succès !";
        } else {
            echo "Erreur lors de la modification : " . $conn->error;
        }
    } else {
        // Insertion d'une nouvelle recette
        $sql = "INSERT INTO recette (nom, description, etapes, categorie_id) VALUES ('$nom', '$description', '$etapes', $categorie_id)";
        if ($conn->query($sql) === TRUE) {
            $recette_id = $conn->insert_id;

            // Insertion des ingrédients associés à la recette
            foreach ($_POST['ingredients'] as $index => $ingredient_id) {
                $quantite = $_POST['quantites'][$index];
                $unite_mesure = $_POST['unites_mesure'][$index];
                $sql_recette_ingredient = "INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite, unite_mesure) VALUES ($recette_id, $ingredient_id, $quantite, '$unite_mesure')";
                $conn->query($sql_recette_ingredient);
            }
            echo "Recette ajoutée avec succès !";
        } else {
            echo "Erreur : " . $conn->error;
        }
    }
}

// Supprimer une recette
if (isset($_GET['supprimer_recette'])) {
    $recette_id = $_GET['supprimer_recette'];
    $sql = "DELETE FROM recette WHERE recette_id = $recette_id";
    if ($conn->query($sql) === TRUE) {
        echo "Recette supprimée avec succès !";
    } else {
        echo "Erreur lors de la suppression : " . $conn->error;
    }
}

// Récupérer toutes les recettes
$sql_recettes = "SELECT * FROM recette";
$result_recettes = $conn->query($sql_recettes);

// Récupérer tous les ingrédients
$sql_ingredients = "SELECT * FROM ingredient";
$result_ingredients = $conn->query($sql_ingredients);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des recettes</title>
</head>
<body>
    <h1>Ajouter ou modifier une recette</h1>

    <form action="gestion_recettes.php" method="POST">
        <input type="hidden" name="recette_id" id="recette_id">
        <label for="nom">Nom de la recette :</label>
        <input type="text" name="nom" id="nom" required><br>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea><br>

        <!-- Sélection de la catégorie -->
        <label for="categorie">Catégorie :</label>
        <select name="categorie" id="categorie" required>
            <option value="1">Cuisine</option>
            <option value="2">Salle de bain</option>
            <option value="3">WC</option>
        </select><br>

        <!-- Étapes de la recette -->
        <label for="etapes">Étapes :</label>
        <textarea name="etapes" id="etapes" required></textarea><br>

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

        <input type="submit" id="ajouter_recette" value="Ajouter la recette">
        <input type="submit" id="modifier_recette" value="Modifier la recette" style="display:none;">
    </form>

    <hr>

    <h1>Liste des recettes</h1>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Étapes</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result_recettes->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nom']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['etapes']; ?></td>
            <td>
                <!-- Bouton Modifier pour remplir le formulaire -->
                <button onclick="remplirFormulaire(<?php echo $row['recette_id']; ?>, '<?php echo $row['nom']; ?>', '<?php echo $row['description']; ?>', '<?php echo $row['etapes']; ?>', <?php echo $row['categorie_id']; ?>)">Modifier</button>

                <!-- Lien pour supprimer une recette -->
                <a href="gestion_recettes.php?supprimer_recette=<?php echo $row['recette_id']; ?>">Supprimer</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        let ingredientIndex = 1;

        function ajouterIngredient() {
            const ingredientsDiv = document.getElementById('ingredients');
            const newIngredient = `
                <div class="ingredient">
                    <label for="ingredient_id">Ingrédient :</label>
                    <select name="ingredients[]" required>
                        <?php
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

        function remplirFormulaire(recette_id, nom, description, etapes, categorie_id) {
            // Remplir le formulaire avec les informations de la recette
            document.getElementById('recette_id').value = recette_id;
            document.getElementById('nom').value = nom;
            document.getElementById('description').value = description;
            document.getElementById('etapes').value = etapes;
            document.getElementById('categorie').value = categorie_id;

            // Afficher le bouton "Modifier" et cacher le bouton "Ajouter"
            document.getElementById('ajouter_recette').style.display = 'none';
            document.getElementById('modifier_recette').style.display = 'inline';
        }
    </script>
</body>
</html>
