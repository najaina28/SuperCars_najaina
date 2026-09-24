<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperCar</title>
    <!-- Fichiers CSS Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Icônes Bootstrap (en local) -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <!-- Notre fichier CSS personnalisé -->
    <link rel="stylesheet" href="assets/css/catalogue.css">
</head>

<body>

    <header>
        <?php include('include/header.php'); ?>
    </header>


    <main>

        <!-- Carrousel d'images en haut de la page -->
        <div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel" data-bs-interval="3000">
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
                <p>Découvrez notre sélection exclusive de véhicules d'occasionss et d'occasion en provenance du monde entier
                </p>
            </div>
        </div>




        <div class="container-fluid custom-container py-5">
            <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Rechercher une marque ou un modèle">
                </div>
                <div class="filter-buttons">
                    <i class="fas fa-bars"></i>
                    <button class="btn btn-orange active">Tous</button>
                    <button class="btn btn-light">Porsche</button>
                    <button class="btn btn-light">Audi</button>
                    <button class="btn btn-light">Mercedes</button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="car-card">
                        <img src="assets/images/porsche/main2.jpeg" alt="Porsche GT3 RS">
                        <div class="p-3">
                            <h4>Porsche GT3 RS</h4>
                            <div class="car-specs">
                                <span><i class="bi bi-calendar"></i> 2024</span>
                                <span><i class="bi bi-speedometer2"></i> 2 500 km</span>
                                <span><i class="bi bi-fuel-pump"></i> Essence</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="price">29 000 000 RS</span>
                                <a href="details.php?id=1" class="btn btn-orange-outline">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="car-card">
                        <img src="assets/images/Audi/Audi-RS-6-rouge.jpg" alt="Audi RS6">
                        <div class="p-3">
                            <h4>Audi RS6 ABT</h4>
                            <div class="car-specs">
                                <span><i class="bi bi-calendar"></i> 2023</span>
                                <span><i class="bi bi-speedometer2"></i> 5 000 km</span>
                                <span><i class="bi bi-fuel-pump"></i> Essence</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="price">35 000 000 RS</span>
                                <a href="details.php?id=2" class="btn btn-orange-outline">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="car-card">
                        <img src="assets/images/mercedes/C63-Black-Edition-100.jpg" alt="Mercedes AMG">
                        <div class="p-3">
                            <h4>Mercedes AMG C63 Black Series</h4>
                            <div class="car-specs">
                                <span><i class="bi bi-calendar"></i> 2024</span>
                                <span><i class="bi bi-speedometer2"></i> 3 000 km</span>
                                <span><i class="bi bi-fuel-pump"></i> Essence</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="price">18 000 000 RS</span>
                                <a href="details.php?id=3" class="btn btn-orange-outline">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-5">
                <div class="col-md-4">
                    <div class="car-card">
                        <img src="assets/images/porsche/porsche-911-gt3-rs.webp" alt="Porsche GT3 RS">
                        <div class="p-3">
                            <h4>Porsche 911 GT3 RS</h4>
                            <div class="car-specs">
                                <span><i class="bi bi-calendar"></i> 2025</span>
                                <span><i class="bi bi-speedometer2"></i> 1 500 km</span>
                                <span><i class="bi bi-fuel-pump"></i> Essence</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="price">32 000 000 RS</span>
                                <a href="details.php?id=4" class="btn btn-orange-outline">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="car-card">
                        <img src="assets/images/mercedes/403928-2025-mercedes-benz-g-class.jpg" alt="Audi RS6">
                        <div class="p-3">
                            <h4>Mercedes-Benz G-Class</h4>
                            <div class="car-specs">
                                <span><i class="bi bi-calendar"></i> 2025</span>
                                <span><i class="bi bi-speedometer2"></i> 1 000 km</span>
                                <span><i class="bi bi-fuel-pump"></i> Essence</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="price">15 000 000 RS</span>
                                <a href="details.php?id=5" class="btn btn-orange-outline">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="car-card">
                        <img src="assets/images/Audi/audi-r8.jpg" alt="Mercedes AMG">
                        <div class="p-3">
                            <h4>Audi R8</h4>
                            <div class="car-specs">
                                <span><i class="bi bi-calendar"></i> 2017</span>
                                <span><i class="bi bi-speedometer2"></i> 3 000 km</span>
                                <span><i class="bi bi-fuel-pump"></i> Essence</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="price">8 500 000 RS</span>
                                <a href="details.php?id=6" class="btn btn-orange-outline">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-banner mt-5 text-center">
                <p>Vous ne trouvez pas ce que vous cherchez ?</p>
                <h5>Contactez-nous et nous trouverons le véhicule de vos rêves</h5>
                <a href="contact.php" class="btn btn-white mt-3">Nous contacter</a>
            </div>

        </div>
    </main>


    <footer>
        <?php include('include/footer.html'); ?>
    </footer>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
