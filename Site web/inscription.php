<?php
session_start();

$erreur = "";
if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] == 'mdp')
        $erreur = "Les mots de passe ne correspondent pas.";
    if ($_GET['erreur'] == 'email')
        $erreur = "Cet email est déjà utilisé.";
    if ($_GET['erreur'] == 'conditions')
        $erreur = "Veuillez accepter les conditions d'utilisation.";
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - SUPERCAR</title>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (Local) -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="assets/css/inscription.css">
    <link rel="stylesheet" href="assets/css/notifications.css">
</head>

<body>
    <div class="auth-container container-fluid">
        <div class="auth-wrapper">
            <!-- Panneau Gauche : Image -->
            <div class="auth-panel-image inscription-image">
                <div class="auth-overlay">
                    <img src="assets/images/logo.png" alt="Supercar" class="auth-logo">
                    <h2>Rejoignez le club</h2>
                    <p>Accédez à un catalogue exclusif et vivez l'expérience supercar.</p>
                </div>
            </div>

            <!-- Panneau Droit : Formulaire -->
            <div class="auth-panel-form">
                <div class="inscription-card">
                    <!-- Lien Retour Accueil -->
                    <a href="index.php" class="back-link text-decoration-none text-muted mb-3 d-inline-block small">
                        <i class="bi bi-chevron-left"></i>Retour à l'accueil
                    </a>

                    <h1 class="mb-2">Créer un compte</h1>
                    <p class="text-muted mb-4">Rejoignez SUPERCAR pour accéder à nos offres exclusives</p>

                    <form method="POST" action="backend/traitementInscription.php">
                        <!-- Prénom et Nom -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom"
                                    placeholder="Veuillez entrer votre prénom" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom"
                                    placeholder="Veuillez entrer votre nom" required>
                            </div>
                        </div>

                        <!-- Adresse e-mail et Téléphone -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="email" class="form-label">Adresse e-mail</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Veuillez entrer votre email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" id="telephone" name="telephone"
                                    placeholder="+33 6 12 34 56 89" required>
                            </div>
                        </div>

                        <!-- Mot de passe et Confirmation -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="• • • • • • • • •" required>
                                    <i class="bi bi-eye password-icon"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                        placeholder="• • • • • • • • •" required>
                                    <i class="bi bi-eye password-icon"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Acceptation des conditions -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="conditions" name="conditions">
                                <label class="form-check-label" for="conditions">
                                    J'accepte les <a href="javascript:void(0)" onclick="showLegal('conditions')"
                                        class="link-conditions">conditions d'utilisations</a> et la <a href="javascript:void(0)"
                                        onclick="showLegal('politique')" class="link-confidentialite">politique de
                                        confidentialité</a>
                                </label>
                            </div>
                        </div>

                        <!-- Bouton d'inscription -->
                        <button type="submit" class="btn btn-inscription w-100 mb-4">
                            Créer mon compte
                        </button>

                        <!-- Séparateur -->
                        <div class="separator mb-4">
                            <span>ou</span>
                        </div>

                        <!-- Lien connexion -->
                        <p class="text-center account-text">
                            Vous avez déjà un compte ?
                            <a href="login.php" class="login-link">Se connecter</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/notifications.js"></script>
    <script src="assets/js/legal.js"></script>
    <script src="assets/js/supercar.js"></script>
    <script>
        window.onload = function () {
            initPasswordToggle();
            handleNotifications("<?php echo $erreur; ?>");
        }
    </script>
</body>

</html>