<?php
session_start();
include 'db.php';

// Limite d'inactivité en secondes (10 minutes)
$inactivityLimit = 600; // 600 secondes = 10 minutes

// Si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Vérifier si la dernière activité est définie
    if (isset($_SESSION['last_activity'])) {
        $inactivity = time() - $_SESSION['last_activity'];

        // Si l'inactivité dépasse la limite, détruire la session
        if ($inactivity > $inactivityLimit) {
            session_unset(); // Supprimer toutes les variables de session
            session_destroy(); // Détruire la session
            header("Location: connexion.php?message=session_timeout"); // Rediriger vers la page de connexion
            exit;
        }
    }

    // Mettre à jour le timestamp de la dernière activité
    $_SESSION['last_activity'] = time();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Edu+AU+VIC+WA+NT+Guides:wght@400..700&family=Spicy+Rice&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="site-logo">
            <a href="index.php" style="color: white; text-decoration: none;">EcoClean-Home</a>
        </div>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="cuisine.php">Cuisine</a></li>
                <li class="nav-item"><a href="sdb.php">Salle de bain</a></li>
                <li class="nav-item"><a href="wc.php">WC</a></li>

                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Ces liens ne s'affichent que si l'utilisateur est connecté -->
                    <li class="nav-item"><a href="gestion_ingredients.php">Ajouter ingrédient</a></li>
                    <li class="nav-item"><a href="gestion_recettes.php">Ajouter recette</a></li>
                    <li class="nav-item"><a href="logout.php">Se déconnecter</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="connexion.php">Se connecter</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>

</html>