<?php
include 'header.php';

$recette_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($recette_id == 0) {
    header('Location: index.php');
    exit();
}

$sql_recette = "SELECT * FROM recette WHERE recette_id = $recette_id";
$result_recette = $conn->query($sql_recette);

if ($result_recette->num_rows == 0) {
    echo "<p>Cette recette n'existe pas.</p>";
    exit();
}

$recette = $result_recette->fetch_assoc();

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
    <link rel="stylesheet" href="recette.css">
</head>
<body>
    <div class="recipe-container">
        <h1 class="recipe-title"><?php echo $recette['nom']; ?></h1>
        <p class="recipe-description"><?php echo $recette['description']; ?></p>

        <h2 class="ingredients-title">Ingrédients</h2>
        <ul class="ingredients-list">
            <?php while ($ingredient = $result_ingredients->fetch_assoc()) { ?>
                <li class="ingredients-list-item">
                    <a href="ingredients.php" class="ingredients-link">
                        <?php echo $ingredient['nom']; ?>
                    </a>: <?php echo $ingredient['quantite'] . ' ' . $ingredient['unite_mesure']; ?>
                </li>
            <?php } ?>
        </ul>

        <h2 class="steps-title">Étapes</h2>
        <p class="recipe-steps"><?php echo nl2br($recette['etapes']); ?></p>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
