<?php
// Inclure la connexion à la base de données et le header
include 'db.php';
include 'header.php';

// Récupérer les recettes de la catégorie "WC"
$sql_recettes = "SELECT * FROM recette WHERE categorie_id = 3"; // On suppose que '3' est l'ID pour WC
$result_recettes = $conn->query($sql_recettes);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recettes pour WC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Produits Maison pour les WC</h1>
        <p>Découvrez nos recettes pour des produits écologiques et naturels à utiliser dans vos WC.</p>
        
        <h2>Liste des recettes disponibles :</h2>
        <?php if ($result_recettes->num_rows > 0) { ?>
            <ul>
                <?php while ($row = $result_recettes->fetch_assoc()) { ?>
                    <li>
                        <a href="recette.php?id=<?php echo $row['recette_id']; ?>">
                            <?php echo $row['nom']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>Aucune recette disponible pour les WC.</p>
        <?php } ?>

    </div>
    <?php $conn->close(); ?>
</body>
</html>
