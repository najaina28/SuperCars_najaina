<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperCar - Demande d'essai</title>

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">

    <link rel="stylesheet" href="assets/css/demande-essai.css">
    <link rel="stylesheet" href="assets/css/notifications.css">
</head>

<body>

    <!-- Header Navigation -->
    <?php include('include/header.php'); ?>


    <!-- ─── HERO ─────────────────────────────────────────────────── -->
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


    <!-- ─── WHY SECTION ───────────────────────────────────────────── -->
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


    <!-- ─── FORM SECTION ──────────────────────────────────────────── -->
    <section class="form-section">
        <div class="container px-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="section-title text-center mb-2">Réservez votre essai</h2>
                            <p class="form-subtitle mb-4">Remplissez le formulaire ci-dessous et notre équipe vous
                                contactera rapidement</p>

                            <form id="essaiForm" novalidate>

                                <!-- Row 1: Prénom + Nom -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Prénom <span class="required">*</span></label>
                                        <input type="text" class="form-control"
                                            placeholder="Veuillez entrer votre prénom" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nom <span class="required">*</span></label>
                                        <input type="text" class="form-control" placeholder="Veuillez entrer votre nom"
                                            required>
                                    </div>
                                </div>

                                <!-- Row 2: Email + Téléphone -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Email <span class="required">*</span></label>
                                        <input type="email" class="form-control" placeholder="exemple.email@email.com"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Téléphone <span class="required">*</span></label>
                                        <input type="tel" class="form-control" placeholder="034 85 789 54" required>
                                    </div>
                                </div>

                                <!-- Row 3: Date + Véhicule -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Date préférée <span class="required">*</span></label>
                                        <input type="date" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Véhicule préféré <span
                                                class="required">*</span></label>
                                        <?php 
                                        include 'backend/connexion.php';
                                        include 'backend/fonctionCatalogue.php';
                                        $voitures_list = get_all_voiture($bdd);
                                        $selected_modele = isset($_GET['modele']) ? $_GET['modele'] : '';
                                        ?>
                                        <select class="form-select" required>
                                            <option value="" disabled <?php echo empty($selected_modele) ? 'selected' : ''; ?>>Sélectionnez un véhicule</option>
                                            <?php foreach($voitures_list as $v): 
                                                $full_name = $v['nom_marque'] . ' ' . $v['modele'];
                                            ?>
                                                <option <?php echo ($full_name == $selected_modele) ? 'selected' : ''; ?>><?php echo $full_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Message -->
                                <div class="mb-4">
                                    <label class="form-label">Message (optionnel)</label>
                                    <textarea class="form-control" rows="4"
                                        placeholder="Dites-nous en plus sur votre préférences ou toutes question particulière..."></textarea>
                                </div>

                                <!-- Buttons -->
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-submit">Envoyer ma demande</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="reset" class="btn btn-reset">Réinitialiser</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ─── FOOTER ────────────────────────────────────────────────── -->
    <!-- Footer -->
    <?php include('include/footer.html'); ?>


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
</body>
</html>
