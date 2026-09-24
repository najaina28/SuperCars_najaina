<?php 
    $currentPage = basename($_SERVER['PHP_SELF']); 
?>
<link rel="stylesheet" href="assets/css/header.css">
<header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid px-4">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png" alt="SuperCar Logo" class="d-inline-block align-text-top">
        </a>

        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <nav class="navbar-nav mx-auto gap-4">
                <a class="nav-link fw-500 <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>" href="index.php">Accueil</a>
                <a class="nav-link fw-500 <?php echo ($currentPage == 'catalogue.php' || $currentPage == 'details.php') ? 'active' : ''; ?>" href="catalogue.php">Voitures</a>
                <a class="nav-link fw-500 <?php echo $currentPage == 'demande-essai.php' ? 'active' : ''; ?>" href="demande-essai.php">Demande d'essai</a>
                <a class="nav-link fw-500 <?php echo $currentPage == 'service.php' ? 'active' : ''; ?>" href="service.php">Services</a>
                <a class="nav-link fw-500 <?php echo $currentPage == 'contact.php' ? 'active' : ''; ?>" href="contact.php">Contact</a>
            </nav>

            <!-- Profile Dropdown -->
            <div class="ms-3 dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle gap-2"
                    id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: #333;">
                    <div class="profile-icon-wrapper">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <span class="fw-500 d-none d-lg-block" style="font-weight: 600;">Compte</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="dropdownUser"
                    style="border-radius: 12px; margin-top: 10px;">
                    <?php if (isset($_SESSION['id_client'])): ?>
                        <li><a class="dropdown-item py-2" href="profil.php"><i class="bi bi-person me-2 text-muted"></i>Mon Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="deconnexion.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item py-2" href="login.php"><i class="bi bi-box-arrow-in-right me-2 text-muted"></i>Connexion</a></li>
                        <li><a class="dropdown-item py-2" href="inscription.php"><i class="bi bi-person-plus me-2 text-muted"></i>Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</header>
