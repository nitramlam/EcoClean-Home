<?php
// Inclure la connexion à la base de données et le header
include 'db.php';
include 'header.php';

// Récupérer l'ID de la recette depuis l'URL
$recette_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID n'est passé, rediriger vers une autre page
if ($recette_id == 0) {
    header('Location: index.php'); // Redirection vers l'accueil ou autre page
    exit();
}

// Récupérer les détails de la recette
$sql_recette = "SELECT * FROM recette WHERE recette_id = $recette_id";
$result_recette = $conn->query($sql_recette);

// Vérifier si la recette existe
if ($result_recette->num_rows == 0) {
    echo "<p>Cette recette n'existe pas.</p>";
    exit();
}

// Obtenir les informations de la recette
$recette = $result_recette->fetch_assoc();

// Récupérer les ingrédients de la recette
$sql_ingredients = "
    SELECT i.nom, ri.quantite, ri.unite_mesure 
    FROM ingredient i
    JOIN recette_ingredient ri ON i.ingredient_id = ri.ingredient_id
    WHERE ri.recette_id = $recette_id
";
$result_ingredients = $conn->query($sql_ingredients);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $recette['nom']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $recette['nom']; ?></h1>
        <p><?php echo $recette['description']; ?></p>

        <h2>Ingrédients</h2>
        <ul>
            <?php while ($ingredient = $result_ingredients->fetch_assoc()) { ?>
                <li>
                    <a href="ingredient_detail.php?nom=<?php echo urlencode($ingredient['nom']); ?>">
                        <?php echo $ingredient['nom']; ?>
                    </a>: <?php echo $ingredient['quantite'] . ' ' . $ingredient['unite_mesure']; ?>
                </li>
            <?php } ?>
        </ul>

        <h2>Étapes</h2>
        <p><?php echo nl2br($recette['etapes']); ?></p>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
