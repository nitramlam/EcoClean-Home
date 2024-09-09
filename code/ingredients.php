<?php
// Inclure la connexion à la base de données et le header
include 'db.php';
include 'header.php';

// Récupérer tous les ingrédients
$sql_ingredients = "SELECT * FROM ingredient";
$result_ingredients = $conn->query($sql_ingredients);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Ingrédients</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <h1>Liste des Ingrédients</h1>

    <?php if ($result_ingredients->num_rows > 0) { ?>
        <ul>
            <?php while ($row = $result_ingredients->fetch_assoc()) { ?>
                <li>
                    <strong><?php echo $row['nom']; ?>:</strong> 
                    <p><?php echo $row['description']; ?></p>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>Aucun ingrédient trouvé.</p>
    <?php } ?>

    <?php $conn->close(); ?>
</body>
</html>
