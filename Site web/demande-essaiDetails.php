<?php
session_start();

// Sécurité : rediriger si pas connecté
if (!isset($_SESSION['id_client']) || empty($_SESSION['id_client'])) {
    header('Location: login.php?erreur=connexion');
    exit();
}

// Récupérer l'ID de la voiture depuis l'URL
$id_voiture = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_voiture <= 0) {
    header('Location: catalogue.php');
    exit();
}

// Récupérer les infos du client depuis la session
$prenom    = $_SESSION['nom']    ;
$nom       = $_SESSION['prenom']       ;
$email     = $_SESSION['mail']     ;
$telephone = $_SESSION['telephone'] ;

// Récupérer le nom complet du véhicule (optionnel mais recommandé)
include 'backend/fonctionsDetails.php'; // ou le fichier qui contient vos fonctions
$voiture = getFullVoiture($id_voiture); // ← fonction qui existe déjà dans details.php

$nom_voiture = $voiture 
    ? $voiture['nom_marque'] . ' ' . $voiture['modele'] 
    : 'Véhicule sélectionné';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperCar - Demande d'essai - <?= htmlspecialchars($nom_voiture) ?></title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/demande-essai.css">
</head>
<body>

<?php include('include/header.php'); ?>

<div class="container px-4">
        <div class="hero-section">
            <!-- Text -->
            <div class="hero-text">
                <h1 class="hero-title">Vivez l'expérience SUPERCAR</h1>
                <p class="hero-subtitle">Réservez votre essai et découvrez la puissance et<br>le luxe de nos véhicules
                    d'exception</p>
            </div>

            <!-- Car visual: Image -->
            <div class="hero-car-visual">
                <img src="assets/images/background/demande.jpg" alt="Demande d'essai" class="img-fluid rounded w-100"
                    style="object-fit: cover; max-height: 400px;">
            </div>
        </div>
    </div>

<!-- WHY SECTION (inchangée) -->
<section class="why-section">
        <div class="container px-4">
            <h2 class="section-title">Pourquoi faire un essai ?</h2>
            <div class="row g-3">

                <!-- Card 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-wrap">
                            <i class="bi bi-car-front-fill"></i>
                        </div>
                        <h5>Ressentez la puissance</h5>
                        <p>Rien ne remplace la sensation au volant. Découvrez les performances exceptionnelles de nos
                            véhicules.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-wrap">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h5>Sans engagement</h5>
                        <p>Essayez nos véhicules en toute liberté, sans obligation d'achat. Prenez le temps de décider.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-wrap">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <h5>Accompagnement expert</h5>
                        <p>Profitez des conseils de nos spécialistes passionnés pendant toute la durée de l'essai.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

<!-- FORM SECTION -->
<section class="form-section">
    <div class="container px-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="section-title text-center mb-2">Réservez votre essai</h2>
                        <p class="form-subtitle mb-4 text-center">
                            Pour <strong><?= htmlspecialchars($nom_voiture) ?></strong>
                        </p>

                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-info"><?= htmlspecialchars($_SESSION['message']) ?></div>
                            <?php unset($_SESSION['message']); ?>
                        <?php endif; ?>

                        <form id="essaiForm" action="backend/traitement-essai.php" method="POST" novalidate>

                            <input type="hidden" name="id_voiture" value="<?= $id_voiture ?>">

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Prénom <span class="required">*</span></label>
                                    <input type="text" name="prenom" class="form-control" 
                                           value="<?= htmlspecialchars($prenom) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nom <span class="required">*</span></label>
                                    <input type="text" name="nom" class="form-control" 
                                           value="<?= htmlspecialchars($nom) ?>" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="required">*</span></label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?= htmlspecialchars($email) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Téléphone <span class="required">*</span></label>
                                    <input type="tel" name="telephone" class="form-control" 
                                           value="<?= htmlspecialchars($telephone) ?>" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Date préférée <span class="required">*</span></label>
                                    <input type="date" name="date_essai" class="form-control" 
                                           min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Véhicule</label>
                                    <input type="text" class="form-control bg-light" 
                                           value="<?= htmlspecialchars($nom_voiture) ?>" readonly>
                                    <!-- On garde hidden pour l'ID -->
                                    <input type="hidden" name="id_voiture" value="<?= $id_voiture ?>">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Message (optionnel)</label>
                                <textarea name="message" class="form-control" rows="4" 
                                          placeholder="Dites-nous en plus..."></textarea>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-submit w-100">Envoyer ma demande</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="reset" class="btn btn-reset w-100">Réinitialiser</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('include/footer.html'); ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>