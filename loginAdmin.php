<?php
session_start();

// Si déjà connecté en admin, rediriger vers le dashboard
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('location: index.php');
    exit();
}

$erreur = "";
$succes = "";

if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] == 'email')
        $erreur = "Aucun compte trouvé avec cet email.";
    if ($_GET['erreur'] == 'mdp')
        $erreur = "Mot de passe incorrect.";
    if ($_GET['erreur'] == 'acces')
        $erreur = "Accès refusé. Ce compte n'a pas les droits administrateur.";
}

if (isset($_GET['succes'])) {
    if ($_GET['succes'] == 'deconnexion')
        $succes = "Vous avez été déconnecté avec succès.";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - SUPERCAR</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- CSS Admin Login -->
    <link rel="stylesheet" href="assets/loginAdmin.css">
    <!-- CSS Notifications -->
    <link rel="stylesheet" href="../assets/css/notifications.css">
</head>

<body>

    <div class="login-wrapper">

        <!-- Panneau gauche : décoration -->
        <div class="login-panel-left">
            <div class="panel-brand">
                <img src="assets/images/logo.png" alt="Supercar" class="panel-logo">
                <div class="panel-badge">Administration</div>
            </div>
            <div class="panel-tagline">
                <h2>Espace Administrateur</h2>
                <p>Gérez votre catalogue, vos demandes d'essai et le contenu de votre site depuis cet espace sécurisé.</p>
            </div>
            <div class="panel-decoration">
                <div class="deco-circle deco-1"></div>
                <div class="deco-circle deco-2"></div>
                <div class="deco-circle deco-3"></div>
            </div>
        </div>

        <!-- Panneau droit : formulaire -->
        <div class="login-panel-right">
            <div class="login-card">

                <!-- Lien retour site -->
                <a href="../index.php" class="back-link">
                    <i class="bi bi-chevron-left"></i> Retour au site
                </a>

                <!-- Icône cadenas -->
                <div class="login-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>

                <h1 class="login-title">Connexion Admin</h1>
                <p class="login-subtitle">Accédez à votre tableau de bord</p>

                <form method="POST" action="backend/traitementLoginAdmin.php" class="login-form">

                    <!-- Adresse e-mail -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Adresse e-mail
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="Veuillez entrer votre email"
                            required
                            autocomplete="email">
                    </div>

                    <!-- Mot de passe -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Mot de passe
                        </label>
                        <div class="password-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input"
                                placeholder="••••••••••••"
                                required
                                autocomplete="current-password">
                            <i class="bi bi-eye password-toggle" id="password-toggle"></i>
                        </div>
                    </div>

                    <!-- Bouton connexion -->
                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Se connecter
                    </button>

                </form>

                <p class="login-footer-text">
                    <i class="bi bi-lock-fill"></i>
                    Accès réservé aux administrateurs autorisés.
                </p>

            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="../assets/js/notifications.js"></script>
    <script src="../assets/js/supercar.js"></script>
    <script>
        // Toggle affichage mot de passe
        const toggle = document.getElementById('password-toggle');
        const passwordInput = document.getElementById('password');

        toggle.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggle.classList.toggle('bi-eye', !isPassword);
            toggle.classList.toggle('bi-eye-slash', isPassword);
        });

        // Notifications
        window.onload = function () {
            if (typeof handleNotifications === 'function') {
                handleNotifications("<?php echo $erreur; ?>", "<?php echo $succes; ?>");
            }
        };
    </script>

</body>

</html>
