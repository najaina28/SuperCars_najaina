<?php
session_start();

include 'backend/fonctionsDetails.php';

$id_voiture = isset($_GET['id']) ? $_GET['id'] : 0;

$voiture = getFullVoiture($id_voiture);

if (!$voiture) {
    header('location: catalogue.php');
    exit();
}

$images = getImagesArray($id_voiture);
$similaires = getSimilairesData($voiture['id_marque'], $id_voiture);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $voiture['nom_marque'] . ' ' . $voiture['modele']; ?> - SuperCar</title>

    <!-- Bootstrap CSS (Local) -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (Local) -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/details.css">
    <link rel="stylesheet" href="assets/css/notifications.css">
</head>

<body>

    <?php include('include/header.php'); ?>

    <main class="container-fluid px-4 my-5 mt-5">
        <div class="row gx-4 justify-content-center breadcrumb-area animate-fade-in-up delay-1">
            <div class="col-lg-10 col-xl-10 col-custom-similar">
                <a href="catalogue.php" class="btn-back text-decoration-none">
                    <i class="bi bi-arrow-left-short fs-4 me-1"></i>Retour au catalogue
                </a>
            </div>
        </div>

        <div class="row gx-4 justify-content-center">

            <!-- COLONNE GAUCHE : Galerie d'images -->
            <div class="col-lg-5 col-xl-5 col-custom mb-4 animate-fade-in-up delay-2">


                <!-- Carousel dynamique -->
                <div id="carImageCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $count_images = count($images);
                        if ($count_images > 0):
                            for ($i = 0; $i < $count_images; $i++): ?>
                                <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo $images[$i]; ?>" class="d-block w-100"
                                        alt="<?php echo $voiture['modele']; ?>">
                                </div>
                            <?php endfor; ?>
                        <?php else: ?>
                            <div class="carousel-item active">
                                <img src="assets/images/no-image.jpg" class="d-block w-100" alt="Pas d'image disponible">
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carImageCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>

                    <!-- Miniatures dynamiques -->
                    <div class="carousel-indicators row g-2 justify-content-start mt-2">
                        <?php for ($i = 0; $i < $count_images; $i++): ?>
                            <div class="col-2">
                                <div class="thumbnail-wrapper <?php echo $i === 0 ? 'active' : ''; ?>"
                                    data-bs-target="#carImageCarousel" data-bs-slide-to="<?php echo $i; ?>">
                                    <img src="<?php echo $images[$i]; ?>" class="img-fluid"
                                        alt="Miniature <?php echo $i + 1; ?>">
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- DESCRIPTION dynamique -->
                <div class="description-card mt-4">
                    <h2 class="description-title">Description</h2>
                    <p class="description-text">
                        <?php echo nl2br($voiture['details']); ?>
                    </p>
                </div>

            </div>

            <!-- COLONNE DROITE : Détails du véhicule -->
            <div class="col-lg-5 col-xl-5 col-custom animate-fade-in-up delay-3">


                <!-- UNE SEULE carte blanche pour tout -->
                <div class="vehicle-card">

                    <!-- Titre et Prix dynamiques -->
                    <h1 class="car-title"><?php echo $voiture['nom_marque'] . ' ' . $voiture['modele']; ?></h1>
                    <p class="car-price"><?php echo formatPrix($voiture['prix']); ?></p>

                    <!-- Titre Caractéristiques -->
                    <h2 class="card-title">Caractéristiques</h2>

                    <!-- Caractéristiques avec icônes -->
                    <div class="char-list">
                        <div class="char-item">
                            <div class="char-icon">
                                <i class="bi bi-tag"></i>
                            </div>
                            <div class="char-info">
                                <span class="char-label">Marque</span>
                                <span class="char-value"><?php echo $voiture['nom_marque']; ?></span>
                            </div>
                        </div>

                        <div class="char-item">
                            <div class="char-icon">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <div class="char-info">
                                <span class="char-label">Année</span>
                                <span class="char-value"><?php echo formatAnnee($voiture['datesortie']); ?></span>
                            </div>
                        </div>

                        <div class="char-item">
                            <div class="char-icon">
                                <i class="bi bi-speedometer2"></i>
                            </div>
                            <div class="char-info">
                                <span class="char-label">Kilométrage</span>
                                <span class="char-value"><?php echo formatKm($voiture['kilometrage']); ?></span>
                            </div>
                        </div>

                        <div class="char-item">
                            <div class="char-icon">
                                <i class="bi bi-fuel-pump"></i>
                            </div>
                            <div class="char-info">
                                <span class="char-label">Carburant</span>
                                <span class="char-value"><?php echo $voiture['carburant']; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Spécifications dynamiques -->
                    <div class="specs-list">
                        <div class="spec-item">
                            <span class="spec-label">Transmission</span>
                            <span class="spec-value"><?php echo $voiture['boite_de_vitesse']; ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Puissance</span>
                            <span class="spec-value"><?php echo $voiture['puissance']; ?> Ch</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Couleur</span>
                            <span class="spec-value"><?php echo $voiture['couleur']; ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Provenance</span>
                            <span class="spec-value"><?php echo $voiture['provenance']; ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Disponibilité</span>
                            <span class="spec-value"><?php echo formatDispo($voiture['disponibilite']); ?></span>
                        </div>
                    </div>

                    <!-- Boutons d'action (dans la même carte) -->
                    <div class="action-buttons">
                        <a href="demande-essai.php?id=<?php echo $voiture['idvoiture']; ?>" class="btn-orange-full text-center text-decoration-none d-block">Demander un essai</a>
                    </div>


                </div>

            </div>

        </div>

        <!-- Section Véhicules similaires -->
        <div class="row mt-5 justify-content-center animate-fade-in-up delay-4">
            <div class="col-lg-10 col-xl-10 col-custom-similar">
                <h2 class="similar-title">Véhicules similaires</h2>
            </div>
        </div>


        <div class="row g-4 mt-2 justify-content-center">
            <div class="col-lg-10 col-xl-10 col-custom-similar">
                <div class="row g-4">
                    <?php while ($sim = mysqli_fetch_assoc($similaires)): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="similar-card">
                                <div class="similar-image">
                                    <img src="<?php echo $sim['main_image'] ?: 'assets/images/no-image.jpg'; ?>"
                                        alt="<?php echo $sim['modele']; ?>">
                                </div>
                                <div class="similar-body">
                                    <h3 class="similar-car-name"><?php echo $sim['nom_marque'] . ' ' . $sim['modele']; ?>
                                    </h3>
                                    <div class="similar-specs">
                                        <span class="similar-spec"><i class="bi bi-calendar3"></i>
                                            <?php echo formatAnnee($sim['datesortie']); ?></span>
                                        <span class="similar-spec"><i class="bi bi-speedometer2"></i>
                                            <?php echo formatKm($sim['kilometrage']); ?></span>
                                        <span class="similar-spec"><i class="bi bi-fuel-pump"></i>
                                            <?php echo $sim['carburant']; ?></span>
                                    </div>
                                    <div class="similar-footer">
                                        <span class="similar-price"><?php echo formatPrix($sim['prix']); ?></span>
                                        <a href="details.php?id=<?php echo $sim['idvoiture']; ?>"
                                            class="btn btn-orange-outline">Voir détails</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

    </main>

    <?php include('include/footer.html'); ?>

    <!-- Bootstrap JS (Local) -->
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