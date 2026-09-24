<?php
// S'assurer que les données ont été envoyées
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header('location: login.php');
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

// Tableau des images du captcha (true = image valide à cocher)
$images = [
    'voiture1.jpg' => true,
    'voiture2.jpg' => true,
    'voiture3.jpg' => true,
    'voiture4.jpg' => true,
    'plage.png' => false,
    'batiment.png' => false,
    'chien.png' => false,
    'pizza.png' => false,
    'montagne.png' => false
];

$images_noms = array_keys($images);
shuffle($images_noms); // Mélanger les images aléatoirement

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de sécurité - SUPERCAR</title>

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .verif-card {
            max-width: 450px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .text-orange {
            color: #d35400;
        }

        .btn-orange {
            background-color: #d35400;
            color: white;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
        }

        .btn-orange:hover {
            background-color: #a04000;
            color: white;
        }

        .captcha-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .captcha-item {
            position: relative;
            cursor: pointer;
            width: 100%;
            aspect-ratio: 1;
        }

        .captcha-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 4px solid transparent;
            transition: all 0.2s ease;
        }

        .checkbox-hidden {
            display: none;
        }

        /* Style quand l'image est sélectionnée */
        .checkbox-hidden:checked+.captcha-img {
            border-color: #d35400;
            filter: brightness(0.8);
            transform: scale(0.95);
        }
    </style>
</head>

<body class="bg-light vh-100 d-flex align-items-center justify-content-center">

    <div class="verif-card w-100">
        <h2 class="text-center mb-3">Vérification</h2>
        <p class="text-center text-muted mb-4">Veuillez sélectionner toutes les images contenant une <strong
                class="text-orange">voiture</strong> pour prouver que vous n'êtes pas un robot.</p>

        <?php if (isset($_GET['erreur']) && $_GET['erreur'] == 'captcha'): ?>
            <div class="alert alert-danger text-center"><i class="bi bi-exclamation-triangle"></i> Vérification échouée,
                veuillez réessayer.</div>
        <?php endif; ?>

        <form action="backend/traitementLogin.php" method="POST">
            <!-- On renvoie les identifiants en cachette au vrai traitement -->
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">

            <!-- Grille du captcha -->
            <div class="captcha-grid">
                <?php foreach ($images_noms as $img): ?>
                    <label class="captcha-item">
                        <input type="checkbox" name="captcha[]" value="<?php echo $img; ?>" class="checkbox-hidden">
                        <img src="assets/images/captcha/<?php echo $img; ?>" class="captcha-img" alt="Captcha">
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-orange w-100 mt-2">Valider la connexion</button>
            <a href="login.php" class="btn btn-outline-secondary w-100 mt-2">Annuler</a>
        </form>
    </div>

</body>

</html>
