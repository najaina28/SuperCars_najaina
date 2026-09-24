<?php 
session_start(); 
require_once 'backend/connexion.php';
require_once 'backend/fonctionContenu.php';

$accueil_contents = get_all_contenu_by_page($bdd, 'accueil');
$hero = find_contenu($accueil_contents, 1);

$apropos_contents = get_all_contenu_by_page($bdd, 'apropos');
$apropos_main = find_contenu($apropos_contents, 1);

$processus_contents = get_all_contenu_by_page($bdd, 'processus');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperCar - Votre partenaire de confiance pour les voitures d'occasionss</title>

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/accueil.css">
    <link rel="stylesheet" href="assets/css/notifications.css">

</head>

<body>

    <!-- Header Navigation -->
    <?php include('include/header.php'); ?>

    <!-- Hero Section -->
    <section class="hero-section" style="background-image: url('assets/images/<?= ($hero && !empty($hero['image'] ?? '')) ? $hero['image'] : 'background/porsche.jpg' ?>')">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title"><?= $hero ? $hero['titre'] : "Votre partenaire de confiance pour les voitures d'occasionss<br>depuis 2009" ?></h1>
            <a href="catalogue.php" class="btn-orange-hero"><?= $hero ? $hero['texte'] : "Consulter le catalogue" ?></a>
        </div>
    </section>

    <section class="about-section">
        <div class="container py-5">
            <div class="text-center mb-5" style="max-width: 800px; margin: 0 auto;">
                <h2 class="section-title"><?= $apropos_main ? $apropos_main['titre'] : "À propos de SuperCar" ?></h2>
                <p class="section-description"><?= $apropos_main ? $apropos_main['texte'] : "Depuis 2009, SuperCar est votre partenaire de confiance dans l'acquisition de voitures d'occasionss." ?></p>
            </div>

            <div class="row g-4 justify-content-center">
                <?php foreach ($apropos_contents as $item): ?>
                    <?php if ($item['lignecontenu'] > 1): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="info-card">
                            <div class="info-icon-wrap">
                                <?php 
                                    // Définition des icônes par défaut selon la ligne
                                    $icon = "bi-check-circle";
                                    if ($item['lignecontenu'] == 2) $icon = "bi-globe";
                                    if ($item['lignecontenu'] == 3) $icon = "bi-houses-fill";
                                    if ($item['lignecontenu'] == 4) $icon = "bi-shop";
                                ?>
                                <i class="bi <?= $icon ?>"></i>
                            </div>
                            <h3 class="info-card-title"><?= $item['titre'] ?></h3>
                            <p class="info-card-text"><?= $item['texte'] ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                
                <?php if (empty($apropos_contents)): ?>
                    <!-- Affichage par défaut si la base est vide -->
                    <div class="col-lg-4 col-md-6">
                        <div class="info-card">
                            <div class="info-icon-wrap"><i class="bi bi-globe"></i></div>
                            <h3 class="info-card-title">Importation mondiale</h3>
                            <p class="info-card-text">Véhicules d'occasionss en provenance du monde entier.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Section Notre Processus -->
    <section class="process-section">
        <div class="container py-5">
            <h2 class="section-title text-center mb-5">Notre Processus</h2>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <?php foreach ($processus_contents as $step): ?>
                        <?php $dir = ($step['lignecontenu'] % 2 == 0) ? 'from-right' : 'from-left'; ?>
                        <div class="process-step <?= $dir ?>">
                            <div class="step-number"><?= $step['lignecontenu'] ?></div>
                            <div class="step-content">
                                <h3 class="step-title"><?= $step['titre'] ?></h3>
                                <p class="step-text"><?= $step['texte'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (empty($processus_contents)): ?>
                        <div class="process-step from-left">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h3 class="step-title">Découverte</h3>
                                <p class="step-text">Explorez notre catalogue et sélectionnez le modèle qui vous intéresse</p>
                            </div>
                        </div>
                        <div class="process-step from-right">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h3 class="step-title">Essai au Siège Social</h3>
                                <p class="step-text">Testez une voiture d'essai de chaque modèle dans notre showroom</p>
                            </div>
                        </div>
                        <div class="process-step from-left">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h3 class="step-title">Livraison</h3>
                                <p class="step-text">Recevez un véhicule d'occasions identique, livré directement depuis nos entrepôts</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-section"><?php include('include/footer.html'); ?>

        <!-- Bootstrap JS -->
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/notifications.js"></script>
        <script src="assets/js/supercar.js"></script>
        <script>
            window.onload = function () {
                let message = "<?php echo isset($_GET['succes']) ? htmlspecialchars($_GET['succes']) : ''; ?>";
                let error = "<?php echo isset($_GET['erreur']) ? htmlspecialchars($_GET['erreur']) : ''; ?>";
                handleNotifications(error, message);
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var section = document.querySelector('.process-section');
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            section.classList.add('animate');
                            observer.unobserve(section);
                        }
                    });
                }, { threshold: 0.70 });
                observer.observe(section);
            });
        </script>
</body>
</html>
