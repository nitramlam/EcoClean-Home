<?php
include 'db.php';

// Ajouter ou modifier un ingrédient
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    if (isset($_POST['ingredient_id']) && !empty($_POST['ingredient_id'])) {
        // Si un ID est passé, on modifie l'ingrédient
        $ingredient_id = $_POST['ingredient_id'];
        $sql = "UPDATE ingredient SET nom = '$nom', description = '$description' WHERE ingredient_id = $ingredient_id";
        if ($conn->query($sql) === TRUE) {
            echo "Ingrédient modifié avec succès !";
        } else {
            echo "Erreur lors de la modification : " . $conn->error;
        }
    } else {
        // Sinon, on ajoute un nouvel ingrédient
        $sql = "INSERT INTO ingredient (nom, description) VALUES ('$nom', '$description')";
        if ($conn->query($sql) === TRUE) {
            echo "Ingrédient ajouté avec succès !";
        } else {
            echo "Erreur lors de l'ajout : " . $conn->error;
        }
    }
}

// Supprimer un ingrédient
if (isset($_GET['supprimer'])) {
    $ingredient_id = $_GET['supprimer'];
    $sql = "DELETE FROM ingredient WHERE ingredient_id = $ingredient_id";
    if ($conn->query($sql) === TRUE) {
        echo "Ingrédient supprimé avec succès !";
    } else {
        echo "Erreur lors de la suppression : " . $conn->error;
    }
}

// Récupérer tous les ingrédients
$sql = "SELECT * FROM ingredient";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des ingrédients</title>
</head>
<body>
    <h1>Ajouter ou modifier un ingrédient</h1>

    <form action="gestion_ingredients.php" method="POST">
        <input type="hidden" name="ingredient_id" value="">
        <label for="nom">Nom de l'ingrédient :</label>
        <input type="text" name="nom" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>

        <input type="submit" value="Ajouter ou modifier l'ingrédient">
    </form>

    <hr>

    <h1>Liste des ingrédients</h1>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nom']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td>
                <!-- Bouton pour modifier -->
                <button onclick="remplirFormulaire(<?php echo $row['ingredient_id']; ?>, '<?php echo $row['nom']; ?>', '<?php echo $row['description']; ?>')">Modifier</button>

                <!-- Lien pour supprimer -->
                <a href="gestion_ingredients.php?supprimer=<?php echo $row['ingredient_id']; ?>">Supprimer</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        // Fonction pour remplir le formulaire de modification
        function remplirFormulaire(ingredient_id, nom, description) {
            document.querySelector('input[name="ingredient_id"]').value = ingredient_id;
            document.querySelector('input[name="nom"]').value = nom;
            document.querySelector('textarea[name="description"]').value = description;
        }
    </script>
</body>
</html>