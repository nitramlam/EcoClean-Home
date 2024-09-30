<?php
session_start();
include 'db.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête pour vérifier les informations d'identification
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Si l'utilisateur existe et que le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        // Démarre la session pour cet utilisateur
        $_SESSION['user'] = $user['username'];

        // Générer un token CSRF unique pour cette session utilisateur
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        // Rediriger vers la page d'accueil après connexion
        header("Location: index.php");
        exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

// À ce stade, aucune redirection n'a eu lieu, on peut afficher le HTML
include 'header.php'; // Inclusion du header après la redirection potentielle
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="connexion.css">
</head>
<body>
    <h2>Connexion</h2>
    
    <!-- Affichage d'un message d'erreur si les identifiants sont incorrects -->
    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Formulaire de connexion -->
    <form action="connexion.php" method="post">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <button type="button" id="togglePassword">Afficher</button><br><br>

        <button type="submit">Se connecter</button>
    </form>

    <script>
        const togglePasswordButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePasswordButton.addEventListener('click', function () {
            // Vérifie si le mot de passe est actuellement masqué ou visible
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Change le texte du bouton en fonction de l'état
            this.textContent = type === 'password' ? 'Afficher' : 'Masquer';
        });
    </script>
</body>
</html>