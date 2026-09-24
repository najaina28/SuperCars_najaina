<?php
session_start();

$erreur = "";
$succes = "";

if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] == 'email')
        $erreur = "Aucun compte trouvé avec cet email.";
    if ($_GET['erreur'] == 'mdp')
        $erreur = "Mot de passe incorrect.";
    if ($_GET['erreur'] == 'captcha')
        $erreur = "La vérification captcha a échoué. Veuillez réessayer.";
    if ($_GET['erreur'] == 'connexion')
        $erreur = "Vous devez être connecté pour pouvoir faire une demande d'essai.";
}

if (isset($_GET['succes'])) {
    if ($_GET['succes'] == 'inscription')
        $succes = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    if ($_GET['succes'] == 'deconnexion')
        $succes = "Vous avez été déconnecté avec succès. À bientôt !";
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SUPERCAR</title>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (Local) -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="assets/css/connexion.css">
    <link rel="stylesheet" href="assets/css/notifications.css">
</head>

<body>
    <div class="auth-container container-fluid">
        <div class="auth-wrapper">
            <!-- Panneau Gauche : Image -->
            <div class="auth-panel-image login-image">
                <div class="auth-overlay">
                    <img src="assets/images/logo.png" alt="Supercar" class="auth-logo">
                    <h2>Bienvenue chez SUPERCAR</h2>
                    <p>L'excellence automobile à portée de main.</p>
                </div>
            </div>

            <!-- Panneau Droit : Formulaire -->
            <div class="auth-panel-form">
                <div class="connexion-card">
                    <!-- Lien Retour Accueil -->
                    <a href="index.php" class="back-link text-decoration-none text-muted mb-3 d-inline-block small">
                        <i class="bi bi-chevron-left"></i>Retour à l'accueil
                    </a>

                    <h1 class="mb-2">Connexion</h1>
                    <p class="text-muted mb-4">Accédez à votre espace client</p>

                    <form method="POST" action="verifRobot.php">
                        <!-- Adresse e-mail -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Veuillez entrer votre adresse email" required>
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Veuillez entrer votre mot de passe" required>
                                <i class="bi bi-eye password-icon"></i>
                            </div>
                        </div>

                        <!-- Bouton de connexion -->
                        <button type="submit" class="btn btn-connexion w-100 mb-4">
                            Se connecter
                        </button>

                        <!-- Séparateur -->
                        <div class="separator mb-4">
                            <span>ou</span>
                        </div>

                        <!-- Lien création de compte -->
                        <p class="text-center account-text">
                            Vous n'avez pas de compte ?
                            <a href="inscription.php" class="create-account">Créer un compte</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/notifications.js"></script>
    <script src="assets/js/supercar.js"></script>
    <script>
        window.onload = function () {
            initPasswordToggle();
            handleNotifications("<?php echo $erreur; ?>", "<?php echo $succes; ?>");
        }
    </script>
</body>

</html>