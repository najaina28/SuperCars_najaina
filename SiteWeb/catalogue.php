<?php
    session_start();
    include('backend/fonctionCatalogue.php');
    include("backend/connexion.php");
 
    $selected_id = 0;
 
    if (isset($_GET['marque_id'])) {
        $selected_id = intval($_GET['marque_id']);
    }
 
    $recherche = "" ;
 
    if (isset($_GET['indice'])) {
        $recherche = trim($_GET['indice']);
    }
 
    if ($recherche != "") {
    $tab_voitures = get_voiture_by_indice($bdd, $recherche);
    } elseif ($selected_id != 0) {
    $tab_voitures = get_voiture_by_marque($bdd, $selected_id);
    } else {
    $tab_voitures = get_all_voiture($bdd);
    }
 
 
    $tab_model = get_all_modele($bdd);
 
    $lastSlide = $_SESSION['last_slide'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperCar</title>
    <!-- Fichiers CSS Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icônes Bootstrap (en local) -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <!-- Notre fichier CSS personnalisé -->
    <link rel="stylesheet" href="assets/css/catalogue.css">
    <link rel="stylesheet" href="assets/css/notifications.css">
</head>
<body>
    
    <header>
    <?php include ('include/header.php'); ?>
    </header>


    <main>
    
    <!-- Carrousel d'images en haut de la page -->
    <div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/images/background/porsche.jpg" class="d-block w-100" alt="Porsche">
            </div>
            <div class="carousel-item">
                <img src="assets/images/background/background-catalogue.jpg" class="d-block w-100" alt="Supercar">
            </div>
            <div class="carousel-item">
                <img src="assets/images/background/mercedes2.jpg" class="d-block w-100" alt="Supercar">
            </div>
            <div class="carousel-item">
                <img src="assets/images/background/audi5.jpg" class="d-block w-100" alt="Supercar">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        <div class="hero-text">
            <h1>Notre Catalogue de Véhicules</h1>
            <p>Découvrez notre sélection exclusive de véhicules d'occasions en provenance du monde entier</p>
        </div>
    </div>




     <!-- Barre de recherche et les marque de voiture -->
    <div class="container-fluid custom-container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
        <form method="GET" action="#catalogue" id="search-form">
        <div class="search-wrapper" style="position: relative; max-width: 400px; margin: auto;">
    <div class="search-box">
        <input type="text" id="search" name="indice" placeholder="Rechercher une marque ou un modèle">
        <button type="submit" class="search-btn">
            <i class="bi bi-search"></i>
        </button>
    </div>
    <ul id="suggestions"></ul>
    </div>
        </form>
        <div class="filter-buttons">
            <form method="GET" action="#catalogue" id="filter-form">
        <button type="button" class="btn btn-orange active filter-btn" data-marque-id="0" name="marque_id" value="0">Tous</button>
        <?php $tab_marque = get_all_marque($bdd);
        foreach ($tab_marque as $marque) { ?>
            <button type="button" class="btn btn-light filter-btn" data-marque-id="<?php echo $marque['id_marque'];?>" name="marque_id" value="<?php echo $marque['id_marque'];?>"><?php echo $marque['nom_marque'];?></button>
        <?php } ?>
            </form>
        </div>
    </div>


    <div id = "catalogue" class="row g-4">

        <?php 
        if ($selected_id == 0 && $recherche == "") {
        $tab_voitures = get_all_voiture($bdd);
        } if ($recherche != "") {
            $tab_voitures = get_voiture_by_indice($bdd,$recherche);
        } if ($selected_id != 0)  {
            $tab_voitures = get_voiture_by_marque($bdd,$selected_id);
        }
        foreach ($tab_voitures as $voiture) { ?> 
        <div class="col-md-4">
            <div class="car-card">
                <img src="<?php echo $voiture['url_img']; ?>" alt="<?php echo $voiture['nom_marque'] . ' ' . $voiture['modele']; ?>">
                <div class="p-3">
                    <h4><?php echo $voiture['nom_marque'] . ' ' . $voiture['modele']; ?></h4>
                    <div class="car-specs">
                        <span><i class="bi bi-calendar"></i> <?php echo formatAnnee($voiture['datesortie']); ?> </span>
                        <span><i class="bi bi-speedometer2"></i> <?php echo formatKm($voiture['kilometrage']); ?> </span>
                        <span><i class="bi bi-fuel-pump"></i> <?php echo $voiture['carburant']; ?> </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="price"> <?php echo formatPrix($voiture['prix']); ?> </span>
                        <a href="details.php?id=<?php echo $voiture['idvoiture']; ?>" class="btn btn-orange-outline">Voir détails</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>

    <div class="contact-banner mt-5 text-center">
        <p>Vous ne trouvez pas ce que vous cherchez ?</p>
        <h5>Contactez-nous et nous trouverons le véhicule de vos rêves</h5>
        <a href="contact.php" class="btn btn-white mt-3">Nous contacter</a>
    </div>

    </div>
    </main>


    <footer>
    <?php include ('include/footer.html'); ?>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/notifications.js"></script>
    <script src="assets/js/supercar.js"></script>
    <script>
        const suggestionsData = <?php echo json_encode($tab_model, JSON_UNESCAPED_UNICODE) ?: '[]'; ?>;
        window.onload = function () {
            let message = "<?php echo isset($_GET['succes']) ? htmlspecialchars($_GET['succes']) : ''; ?>";
            let error = "<?php echo isset($_GET['erreur']) ? htmlspecialchars($_GET['erreur']) : ''; ?>";
            handleNotifications(error, message);
        }
    </script>
    <script src="assets/js/catalogue_filtre.js"></script>
</body>
</html>