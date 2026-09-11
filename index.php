<?php
session_start();
// Protection : réservé aux admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location: loginAdmin.php');
    exit();
}

$succes = "";
if (isset($_GET['succes']) && $_GET['succes'] == 'connexion') {
    $succes = "Bienvenue, vous êtes connecté en tant qu'administrateur.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Admin Supercar</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/index.css">
    <!-- Notifications CSS -->
    <link rel="stylesheet" href="../assets/css/notifications.css">
</head>
<body>

    <?php include('include/header.php'); ?>

    <div id="main-content">
        <div class="welcome-card">
            <h1>Bienvenue, Administrateur</h1>
            <p>
                C'est ici que vous pouvez gérer l'ensemble de votre catalogue de voitures, 
                répondre aux demandes d'essai et mettre à jour le contenu de votre site Supercar. 
                Utilisez le menu à gauche pour naviguer.
            </p>

            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-car-front"></i></div>
                    <div class="stat-info">
                        <span class="value">24</span>
                        <span class="label">Voitures</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
                    <div class="stat-info">
                        <span class="value">12</span>
                        <span class="label">Demandes d'essai</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-chat-left-text"></i></div>
                    <div class="stat-info">
                        <span class="value">8</span>
                        <span class="label">Nouveaux messages</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('include/footer.php'); ?>

    <!-- Scripts JS pour Notifications -->
    <script src="../assets/js/notifications.js"></script>
    <script src="../assets/js/supercar.js"></script>
    <script>
        window.onload = function() {
            if (typeof handleNotifications === 'function') {
                handleNotifications("", "<?php echo $succes; ?>");
            }
        };
    </script>
