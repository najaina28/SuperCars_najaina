<?php
session_start();

include 'backend/fonctionsProfil.php';

/* Vérifier si le client est connecté via la session */
if (!isset($_SESSION['id_client']) || empty($_SESSION['id_client'])) {
    header('location: login.php');
    exit();
}

$id_client = $_SESSION['id_client'];

$client = getClient($id_client);

if (!$client) {
    header('location: login.php');
    exit();
}

$initiales = getInitiales($client['prenom'], $client['nom']);
$nb_demandes = getNbDemandes($id_client);
$demandes = getDemandesEssai($id_client);

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
        <div class="profile-header-section pt-4">

            <div class="profile-info-section mt-0">

                <!-- Avatar avec Initiales dynamiques -->
                <div class="profile-avatar-container border-0 p-0">
                    <div class="profile-avatar-initials">
                        <?php echo $initiales; ?>
                    </div>
                </div>

                <!-- Nom et Stats dynamiques -->
                <div class="profile-details">
                    <h1 class="profile-name"><?php echo $client['prenom'] . ' ' . $client['nom']; ?></h1>
                    <div class="profile-stats">
                        <span><?php echo $nb_demandes; ?> demande<?php echo $nb_demandes > 1 ? 's' : ''; ?>
                            d'essai</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="profile-actions">
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
                        <button class="nav-link active" id="demandes-tab" data-bs-toggle="tab"
                            data-bs-target="#demandes" type="button" role="tab" aria-controls="demandes"
                            aria-selected="true">Mes demandes</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="infos-tab" data-bs-toggle="tab" data-bs-target="#infos"
                            type="button" role="tab" aria-controls="infos" aria-selected="false">Mes
                            informations</button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 2. CONTENU DES ONGLETS -->
        <div class="mt-4 pb-5">
            <div class="tab-content" id="profileTabsContent">

                <!-- ONGLET 1: MES DEMANDES (dynamique) -->
                <div class="tab-pane fade show active" id="demandes" role="tabpanel" aria-labelledby="demandes-tab">
                    <div class="row justify-content-center">
                        <div class="col-12">

                            <?php if (mysqli_num_rows($demandes) > 0): ?>
                                <?php while ($demande = mysqli_fetch_assoc($demandes)):
                                    $images_voiture = getImagesVoiture($demande['idvoiture']);
                                    ?>

                                    <!-- POST dynamique -->
                                    <div class="feed-post card border-0 shadow-sm mb-4">
                                        <div class="card-body p-0">
                                            <div class="post-header border-bottom-0">
                                                <!-- Mini Avatar Initiale -->
                                                <div class="rounded-circle bg-orange text-white d-flex align-items-center justify-content-center fw-bold"
                                                    style="width: 40px; height: 40px;"><?php echo $initiales; ?></div>
                                                <div class="post-info">
                                                    <h3><?php echo $client['prenom'] . ' ' . $client['nom']; ?></h3>
                                                    <span><?php echo formatDateFr($demande['date_essai']); ?> • <i
                                                            class="bi bi-calendar-event"></i> Demande d'essai</span>
                                                </div>
                                            </div>
                                            <div class="post-content pt-0 pb-3">
                                                <p class="mb-2">Demande d'essai pour la
                                                    <strong><?php echo $demande['nom_marque'] . ' ' . $demande['modele']; ?></strong>.
                                                </p>
                                                <div class="status-badge mb-3">
                                                    <?php echo formatStatut($demande['statut']); ?>
                                                </div>
                                            </div>

                                            <?php if (count($images_voiture) > 0): ?>
                                                <div class="post-photos-grid px-3 pb-3">
                                                    <div style="flex: 1 1 100%;">
                                                        <img src="<?php echo $images_voiture[0]; ?>" class="img-fluid rounded w-100"
                                                            style="height: 400px; object-fit: cover;">
                                                    </div>
                                                    <?php for ($i = 1; $i < min(count($images_voiture), 4); $i++): ?>
                                                        <div style="flex: 1 1 32%;">
                                                            <img src="<?php echo $images_voiture[$i]; ?>"
                                                                class="img-fluid rounded w-100"
                                                                style="height: 150px; object-fit: cover;">
                                                        </div>
                                                    <?php endfor; ?>
                                                </div>
                                            <?php endif; ?>

                                            <div
                                                class="d-flex justify-content-between py-3 border-top mx-3 mt-2 px-2 align-items-center">
                                                <span class="text-muted small">Ref:
                                                    #<?php echo $demande['id_demande']; ?></span>
                                                <a href="details.php?id=<?php echo $demande['idvoiture']; ?>"
                                                    class="btn btn-sm btn-outline-orange">Voir le véhicule</a>
                                            </div>
                                        </div>
                                    </div>

                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-calendar-x display-1 text-muted"></i>
                                    <p class="mt-3 text-muted fs-5">Vous n'avez aucune demande d'essai pour le moment.</p>
                                    <a href="catalogue.php" class="btn btn-orange mt-2">Découvrir nos véhicules</a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <!-- ONGLET 2: MES INFORMATIONS (dynamique) -->
                <div class="tab-pane fade" id="infos" role="tabpanel" aria-labelledby="infos-tab">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="fb-card p-4">
                                <h2
                                    class="fb-card-title mb-4 border-bottom pb-3 d-flex justify-content-between align-items-center">
                                    Mes coordonnées
                                    <button class="btn btn-outline-orange btn-sm" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#edit-infos" aria-expanded="false"
                                        aria-controls="edit-infos">
                                        <i class="bi bi-pencil me-1"></i> Modifier
                                    </button>
                                </h2>

                                <!-- Affichage des infos dynamiques -->
                                <div id="display-infos">
                                    <div class="intro-item mb-4 display-6 fs-5">
                                        <i class="bi bi-person-fill intro-icon me-3 fs-4 text-orange"></i>
                                        <span><strong>Nom :</strong> <?php echo $client['nom']; ?></span>
                                    </div>

                                    <div class="intro-item mb-4 display-6 fs-5">
                                        <i class="bi bi-person-vcard-fill intro-icon me-3 fs-4 text-orange"></i>
                                        <span><strong>Prénom :</strong> <?php echo $client['prenom']; ?></span>
                                    </div>

                                    <div class="intro-item mb-4 display-6 fs-5">
                                        <i class="bi bi-envelope-fill intro-icon me-3 fs-4 text-orange"></i>
                                        <span><strong>Email :</strong> <?php echo $client['mail']; ?></span>
                                    </div>

                                    <div class="intro-item mb-4 display-6 fs-5">
                                        <i class="bi bi-telephone-fill intro-icon me-3 fs-4 text-orange"></i>
                                        <span><strong>Téléphone :</strong>
                                            <?php echo $client['telephone'] ?: 'Non renseigné'; ?></span>
                                    </div>

                                    <div class="intro-item mb-4 display-6 fs-5">
                                        <i class="bi bi-geo-alt-fill intro-icon me-3 fs-4 text-orange"></i>
                                        <span><strong>Adresse :</strong>
                                            <?php echo $client['adresse'] ?: 'Non renseignée'; ?></span>
                                    </div>
                                </div>

                                <!-- Formulaire d'édition (Masqué par défaut) avec valeurs dynamiques -->
                                <div id="edit-infos" class="edit-form-card collapse">
                                    <form action="backend/traitementProfil.php" method="POST">
                                        <input type="hidden" name="action" value="modifier_infos">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nom</label>
                                                <input type="text" class="form-control" name="nom"
                                                    value="<?php echo $client['nom']; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Prénom</label>
                                                <input type="text" class="form-control" name="prenom"
                                                    value="<?php echo $client['prenom']; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="mail"
                                                value="<?php echo $client['mail']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Téléphone</label>
                                            <input type="tel" class="form-control" name="telephone"
                                                value="<?php echo $client['telephone']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Adresse</label>
                                            <input type="text" class="form-control" name="adresse"
                                                value="<?php echo $client['adresse']; ?>">
                                        </div>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="collapse"
                                                data-bs-target="#edit-infos" aria-expanded="false"
                                                aria-controls="edit-infos">Annuler</button>
                                            <button type="submit" class="btn btn-orange">Enregistrer</button>
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
            let message = "";
            let error = "";

            <?php if (isset($_GET['succes'])): ?>
                <?php if ($_GET['succes'] == 'login'): ?>
                    message = "Connexion réussie ! Heureux de vous revoir.";
                <?php elseif ($_GET['succes'] == 'modif'): ?>
                    message = "Vos informations ont été mises à jour avec succès.";
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($_GET['erreur']) && $_GET['erreur'] == 'modif'): ?>
                error = "Une erreur est survenue lors de la mise à jour.";
            <?php endif; ?>

            handleNotifications(error, message);
        }
    </script>
</body>

</html>