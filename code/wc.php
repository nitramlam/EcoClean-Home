<?php
include 'header.php';

$categorie_id = 3;
$categorie_titre = "WC";

$sql_recettes = "SELECT * FROM recette WHERE categorie_id = $categorie_id";
$result_recettes = $conn->query($sql_recettes);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recettes pour WC</title>
    <link rel="stylesheet" href="cuisine.css">
</head>
<body>
    <div class="recipes-container">
        <h1 class="recipes-title">Produits Maison pour les WC</h1>
        <p class="recipes-description">Découvrez nos recettes pour des produits écologiques et naturels à utiliser dans vos WC.</p>
        
        <h2 class="recipes-list-title">Liste des recettes disponibles :</h2>
        <?php if ($result_recettes->num_rows > 0) { ?>
            <ul class="recipes-list">
                <?php while ($row = $result_recettes->fetch_assoc()) { ?>
                    <li class="recipes-list-item">
                        <a href="recette.php?id=<?php echo $row['recette_id']; ?>" class="recipes-link">
                            <?php echo $row['nom']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p class="recipes-empty">Aucune recette disponible pour les WC.</p>
        <?php } ?>
    </div>
    <?php $conn->close(); ?>
</body>
</html>
