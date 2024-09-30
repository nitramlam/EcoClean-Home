<?php
session_start();

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit;
}

include 'header.php'; // Inclusion du header si l'utilisateur est connecté

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $etapes = $_POST['etapes'];
    $categorie_id = $_POST['categorie'];

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO recette (nom, description, etapes, categorie_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nom, $description, $etapes, $categorie_id);
    
    if ($stmt->execute()) {
        $recette_id = $stmt->insert_id;

        foreach ($_POST['ingredients'] as $index => $ingredient_id) {
            $quantite = $_POST['quantites'][$index];
            $unite_mesure = $_POST['unites_mesure'][$index];
            $stmt_ingredient = $conn->prepare("INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite, unite_mesure) VALUES (?, ?, ?, ?)");
            $stmt_ingredient->bind_param("iiis", $recette_id, $ingredient_id, $quantite, $unite_mesure);
            $stmt_ingredient->execute();
        }

        $message = "Recette ajoutée avec succès !";
    } else {
        $message = "Erreur : " . $conn->error;
    }
}

if (isset($_GET['supprimer_recette'])) {
    $recette_id = $_GET['supprimer_recette'];

    $stmt = $conn->prepare("DELETE FROM recette WHERE recette_id = ?");
    $stmt->bind_param("i", $recette_id);

    if ($stmt->execute()) {
        $message = "Recette supprimée avec succès !";
    } else {
        $message = "Erreur lors de la suppression : " . $conn->error;
    }
}

$sql_recettes = "SELECT * FROM recette";
$result_recettes = $conn->query($sql_recettes);

$sql_ingredients = "SELECT * FROM ingredient";
$result_ingredients = $conn->query($sql_ingredients);

$sql_categories = "SELECT * FROM categorie";
$result_categories = $conn->query($sql_categories);

if (isset($_GET['message']) && $_GET['message'] == 'success') {
    $message = "Recette ajoutée avec succès !";
} elseif (isset($_GET['message']) && $_GET['message'] == 'deleted') {
    $message = "Recette supprimée avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des recettes</title>
    <link rel="stylesheet" href="gestion_recettes.css">
</head>
<body>

    <?php if (!empty($message)) { ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'gestion_recettes.php';
            }, 5000);
        </script>
    <?php } ?>

    <h1>Ajouter une recette</h1>

    <form action="gestion_recettes.php" method="POST">
        <label for="nom">Nom de la recette :</label>
        <input type="text" name="nom" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>

        <label for="categorie">Catégorie :</label>
        <select name="categorie" required>
            <?php while ($row = $result_categories->fetch_assoc()) { ?>
                <option value="<?php echo $row['categorie_id']; ?>"><?php echo $row['nom']; ?></option>
            <?php } ?>
        </select><br>

        <label for="etapes">Étapes :</label>
        <textarea name="etapes" required></textarea><br>

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

        <input type="submit" value="Ajouter la recette">
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
            <td><?php echo nl2br($row['etapes']); ?></td>
            <td>
                <a href="gestion_recettes.php?supprimer_recette=<?php echo $row['recette_id']; ?>">Supprimer</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
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
    </script>

</body>
</html>