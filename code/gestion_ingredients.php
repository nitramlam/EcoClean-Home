<?php
session_start();

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit;
}

// Si l'utilisateur est connecté, inclure le reste du contenu
include 'header.php';

// Le reste de ton code pour la gestion des ingrédients
$message = '';

// Vérification du token CSRF
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Accès refusé. Token CSRF invalide.");
    }

    $nom = $_POST['nom'];
    $description = $_POST['description'];

    if (isset($_POST['ingredient_id']) && !empty($_POST['ingredient_id'])) {
        $ingredient_id = $_POST['ingredient_id'];

        // Requête préparée pour modifier un ingrédient
        $stmt = $conn->prepare("UPDATE ingredient SET nom = ?, description = ? WHERE ingredient_id = ?");
        $stmt->bind_param("ssi", $nom, $description, $ingredient_id);
        if ($stmt->execute()) {
            $message = "Ingrédient modifié avec succès !";
        } else {
            $message = "Erreur lors de la modification : " . $conn->error;
        }
    } else {
        // Requête préparée pour ajouter un nouvel ingrédient
        $stmt = $conn->prepare("INSERT INTO ingredient (nom, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $nom, $description);
        if ($stmt->execute()) {
            $message = "Ingrédient ajouté avec succès !";
        } else {
            $message = "Erreur lors de l'ajout : " . $conn->error;
        }
    }
}

// Si une suppression est demandée
if (isset($_GET['supprimer'])) {
    $ingredient_id = $_GET['supprimer'];

    // Requête préparée pour supprimer un ingrédient
    $stmt = $conn->prepare("DELETE FROM ingredient WHERE ingredient_id = ?");
    $stmt->bind_param("i", $ingredient_id);
    if ($stmt->execute()) {
        $message = "Ingrédient supprimé avec succès !";
    } else {
        $message = "Erreur lors de la suppression : " . $conn->error;
    }
}

$sql = "SELECT * FROM ingredient";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des ingrédients</title>
    <link rel="stylesheet" href="gestion_ingredients.css">
</head>
<body>
    <h1>Ajouter ou modifier un ingrédient</h1>

    <?php if (!empty($message)) { ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.message').style.display = 'none';
            }, 5000);
        </script>
    <?php } ?>

    <form action="gestion_ingredients.php" method="POST">
        <input type="hidden" name="ingredient_id" value="">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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
            <td><?php echo htmlspecialchars($row['nom']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td>
                <button onclick="remplirFormulaire(<?php echo $row['ingredient_id']; ?>, '<?php echo htmlspecialchars($row['nom']); ?>', '<?php echo htmlspecialchars($row['description']); ?>')">Modifier</button>
                <a href="gestion_ingredients.php?supprimer=<?php echo $row['ingredient_id']; ?>">Supprimer</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        function remplirFormulaire(ingredient_id, nom, description) {
            document.querySelector('input[name="ingredient_id"]').value = ingredient_id;
            document.querySelector('input[name="nom"]').value = nom;
            document.querySelector('textarea[name="description"]').value = description;
        }
    </script>
</body>
</html>