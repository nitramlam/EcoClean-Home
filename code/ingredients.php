<?php
include 'header.php';

$sql_ingredients = "SELECT * FROM ingredient";
$result_ingredients = $conn->query($sql_ingredients);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Ingrédients</title>
    <link rel="stylesheet" href="ingredients.css">
</head>
<body>
    <div class="ingredients-container">
        <h1 class="ingredients-title">Liste des Ingrédients</h1>

        <?php if ($result_ingredients->num_rows > 0) { ?>
            <ul class="ingredients-list">
                <?php while ($row = $result_ingredients->fetch_assoc()) { ?>
                    <li class="ingredients-list-item">
                        <strong class="ingredient-name"><?php echo $row['nom']; ?>:</strong> 
                        <p class="ingredient-description"><?php echo $row['description']; ?></p>
                        
                        <h3 class="ingredient-recipes-title">Recettes contenant cet ingrédient :</h3>
                        <ul class="ingredient-recipes-list">
                            <?php
                            $ingredient_id = $row['ingredient_id'];
                            $sql_recettes = "SELECT r.recette_id, r.nom 
                                             FROM recette r
                                             JOIN recette_ingredient ri ON r.recette_id = ri.recette_id
                                             WHERE ri.ingredient_id = $ingredient_id";
                            $result_recettes = $conn->query($sql_recettes);

                            if ($result_recettes->num_rows > 0) {
                                while ($recette = $result_recettes->fetch_assoc()) {
                                    ?>
                                    <li class="ingredient-recipes-item">
                                        <a href="recette.php?id=<?php echo $recette['recette_id']; ?>" class="ingredient-recipe-link">
                                            <?php echo $recette['nom']; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            } else {
                                echo "<li class='ingredient-no-recipes'>Aucune recette contenant cet ingrédient.</li>";
                            }
                            ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p class="ingredients-empty">Aucun ingrédient trouvé.</p>
        <?php } ?>

        <?php $conn->close(); ?>
    </div>
</body>
</html>
