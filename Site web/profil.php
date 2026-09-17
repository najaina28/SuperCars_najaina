<?php
 
    session_start();

    include('backend/fonctionProfil.php');
    include("backend/connexion.php");

    if (!isset($_SESSION['id_client'])) {
        header('Location: login.php');
        exit();
    }


    $id_user = $_SESSION['id_client'];
    $info_client =  get_all_info($bdd, $id_user);
    $demande_essai = get_all_demande($bdd, $id_user);

    $nom = $info_client['nom'];
    $prenom = $info_client['prenom'];

    // Logique pour les notifications
    $profil_succes = "";
    $profil_erreur = "";
    if (isset($_GET['succes'])) {
        if ($_GET['succes'] == 'modif') $profil_succes = "Votre profil a été mis à jour avec succès !";
        if ($_GET['succes'] == 'login') $profil_succes = "Heureux de vous revoir ! Connexion réussie.";
    }
    if (isset($_GET['erreur']) && $_GET['erreur'] == 'modif') {
        $profil_erreur = "Une erreur est survenue lors de la mise à jour.";
    }
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - SuperCar</title>
   
    <!-- Bootstrap CSS (Local) -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
   
    <!-- Bootstrap Icons (Local) -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
   
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/profil.css">
    <link rel="stylesheet" href="assets/css/notifications.css">
</head>
<body>
   
    <?php include('include/header.php'); ?>
   
    <!-- Container principal -->
    <div class="profile-container">
       
        <!-- 1. HEADER SECTION -->
        <div class="profile-header-section pt-4 animate-fade-in-up delay-1">

           
            <div class="profile-info-section mt-0">
               
                <!-- Avatar avec Initiales -->
                <div class="profile-avatar-container border-0 p-0">
                    <div class="profile-avatar-initials">
                        <?= strtoupper(substr($prenom ?? 'U', 0, 1) . substr($nom ?? 'S', 0, 1)) ?>
                    </div>
                </div>
               
                <!-- Nom et Stats -->
                <div class="profile-details">
                    <h1 class="profile-name"><?php echo $prenom; ?> <?php echo $nom; ?></h1>
                    <div class="profile-stats">
                        <span><?php echo $info_client['nombre']; ?> demandes d'essai</span>
                    </div>
                </div>
               
                <!-- Actions -->
                <div class="profile-actions">
                    <!-- <button class="btn-action-primary" data-bs-toggle="tab" data-bs-target="#infos" type="button" role="tab" aria-controls="infos">
                        <i class="bi bi-pencil-fill"></i>
                        Modifier mon profil
                    </button> -->
                    <a href="deconnexion.php" class="btn-action-secondary text-danger">
                        <i class="bi bi-box-arrow-right"></i>
                        Déconnexion
                    </a>
                </div>
            </div>
           
            <!-- Navigation -->
            <div class="profile-nav mt-3">
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="demandes-tab" data-bs-toggle="tab" data-bs-target="#demandes" type="button" role="tab" aria-controls="demandes" aria-selected="true">Mes demandes</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="infos-tab" data-bs-toggle="tab" data-bs-target="#infos" type="button" role="tab" aria-controls="infos" aria-selected="false">Mes informations</button>
                    </li>
                </ul>
            </div>
        </div>
       
        <!-- 2. CONTENU DES ONGLETS -->
        <div class="mt-4 pb-5 animate-fade-in-up delay-2">
            <div class="tab-content" id="profileTabsContent">

               
                <!-- ONGLET 1: MES DEMANDES -->
                <div class="tab-pane fade show active" id="demandes" role="tabpanel" aria-labelledby="demandes-tab">
                    <div class="row justify-content-center">
                        <div class="col-12"> <!-- Pleine largeur -->
                           
                            <?php foreach($demande_essai as $demande) { ?>
                            <!-- POST 1 -->
                            <div class="feed-post card border-0 shadow-sm mb-4">
                                <div class="card-body p-0">
                                    <div class="post-header border-bottom-0">
                                        <!-- Mini Avatar Initiale -->
                                        <div class="rounded-circle bg-orange text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">JD</div>
                                        <div class="post-info">
                                            <h3><?php echo $info_client['prenom']; ?> <?php echo $info_client['nom']; ?></h3>
                                            <span>15 février 2024 • <i class="bi bi-calendar-event"></i> Demande d'essai</span>
                                        </div>
                                    </div>
                                    <div class="post-content pt-0 pb-3">
                                        <p class="mb-2">Demande d'essai pour la <strong><?php echo $demande['modele']; ?></strong>.</p>
                                        <div class="status-badge mb-3">
                                            <span class="badge bg-primary text-white rounded-pill px-3 py-2">
                                                <i class="bi bi-hourglass-split me-1"></i> <?php echo $demande['stat']; ?>
                                            </span>
                                        </div>
                                    </div>
                                   
                                    <div class="post-photos-grid px-3 pb-3">
                                        <?php $image_list = get_photo_id($bdd,$demande['id']);
                                            $image_priorite = null;
                                            $image_no_prio = [];
 
                                            foreach($image_list as $image){
                                                if($image['priorite'] == 1) {
                                                    $image_priorite = $image;
                                                }
                                                if($image['priorite'] == 0){
                                                    $image_no_prio[] = $image;
                                                }
                                            }
                                        ?>
                                        <div style="flex: 1 1 100%;">
                                            <img src="assets/images/<?php echo $image_priorite['url_image']; ?>" class="img-fluid rounded w-100" style="height: 400px; object-fit: cover;">
                                        </div>
 
                                            <?php $i = 0;
                                            foreach($image_no_prio as $im) {  ?>
                                        <div style="flex: 1 1 32%;">
                                            <img src="assets/images/<?php echo $im['url_image']; ?>" class="img-fluid rounded w-100" style="height: 150px; object-fit: cover;">
                                        </div>
 
                                            <?php
                                                $i++;
                                                if($i ==3) {
                                                    break;
                                                }
                                            } ?>
                                    </div>
                                   
                                    <div class="d-flex justify-content-between py-3 border-top mx-3 mt-2 px-2 align-items-center">
                                         <span class="text-muted small">Ref: #4582</span>
                                         <a href="details.php?id=<?php echo $demande['id']; ?>" class="btn btn-sm btn-outline-orange">Voir le véhicule</a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                           
                            <!-- Ajouter d'autres posts ici si nécessaire -->
                           
                        </div>
                    </div>
                </div>
 
                <!-- ONGLET 2: MES INFORMATIONS -->
                <div class="tab-pane fade" id="infos" role="tabpanel" aria-labelledby="infos-tab">
                    <div class="row justify-content-center">
                        <div class="col-12"> <!-- Pleine largeur -->
                            <div class="fb-card p-4">
                                <h2 class="fb-card-title mb-4 border-bottom pb-3 d-flex justify-content-between align-items-center">
                                    Mes coordonnées
                                    <button class="btn btn-outline-orange btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-infos" aria-expanded="false" aria-controls="edit-infos">
                                        <i class="bi bi-pencil me-1"></i> Modifier
                                    </button>
                                </h2>
                               
                                <!-- Affichage des infos -->
                                <div id="display-infos">
                                    <div class="intro-item mb-4 display-6 fs-5">
                                        <i class="bi bi-envelope-fill intro-icon me-3 fs-4 text-orange"></i>
                                        <span><?php echo $info_client['mail'];?></span>
                                    </div>
                                   
                                    <div class="intro-item mb-4 display-6 fs-5">
                                        <i class="bi bi-telephone-fill intro-icon me-3 fs-4 text-orange"></i>
                                        <span><?php echo $info_client['telephone'];?></span>
                                    </div>
                                   
                                    <div class="intro-item mb-4 display-6 fs-5">
                                        <i class="bi bi-geo-alt-fill intro-icon me-3 fs-4 text-orange"></i>
                                        <span><?php echo $info_client['adresse'];?></span>
                                    </div>
                                </div>
                               
                                <!-- Formulaire d'édition (Masqué par défaut) -->
                                <div id="edit-infos" class="edit-form-card collapse">
                                    <form action="backend/traitementProfil.php" method="POST">
                                        <input type="hidden" name="action" value="modifier_infos">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Prénom</label>
                                                <input type="text" name="prenom" class="form-control" value="<?php echo $info_client['prenom'];?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nom</label>
                                                <input type="text" name="nom" class="form-control" value="<?php echo $info_client['nom'];?>" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="mail" class="form-control" value="<?php echo $info_client['mail'];?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Téléphone</label>
                                            <input type="tel" name="telephone" class="form-control" value="<?php echo $info_client['telephone'];?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Adresse</label>
                                            <input type="text" name="adresse" class="form-control" value="<?php echo $info_client['adresse'];?>" required>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#edit-infos" aria-expanded="false" aria-controls="edit-infos">Annuler</button>
                                            <button type="submit" class="btn btn-orange">Enregistrer les modifications</button>
                                        </div>
                                    </form>
                                </div>
 
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
       
    </div>
   
    <?php include('include/footer.html'); ?>
   
    <!-- Bootstrap JS (Local) -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/notifications.js"></script>
    <script src="assets/js/supercar.js"></script>
    <script>
        window.onload = function () {
            let message = "<?php echo $profil_succes; ?>";
            let error = "<?php echo $profil_erreur; ?>";
            handleNotifications(error, message);
        }
    </script>
</body>
</html>
 