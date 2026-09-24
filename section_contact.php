<?php
session_start();
// Protection : réservé aux admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location: loginAdmin.php');
    exit();
}
include 'backend/gestion_accueil/FonctionContenu.php';

// Gestion de la suppression
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if (supprimer_contenu($id)) {
        $_SESSION['msg'] = "Élément supprimé.";
    }
    header("Location: section_contact.php");
    exit();
}

// Récupération des données
$contact_contents = get_contenu_by_page('contact');
$count_rows = count($contact_contents);

// Récupération du contenu à modifier
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_data = get_contenu_by_id($edit_id);
}

// Helper pour récupérer par ligne contenu
$phone    = null;
$email    = null;
$adresse  = null;
$lun_ven  = null;
$samedi   = null;
$dimanche = null;
$gmap     = null;

foreach ($contact_contents as $c) {
    if ($c['lignecontenu'] == 1) $phone = $c;
    if ($c['lignecontenu'] == 2) $email = $c;
    if ($c['lignecontenu'] == 3) $adresse = $c;
    if ($c['lignecontenu'] == 4) $lun_ven = $c;
    if ($c['lignecontenu'] == 5) $samedi = $c;
    if ($c['lignecontenu'] == 6) $dimanche = $c;
    if ($c['lignecontenu'] == 7) $gmap = $c;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Contact - Supercar Admin</title>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Style -->
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/section_hero.css">
    <link rel="stylesheet" href="../Site web/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Site web/assets/css/contact.css">
    <style>
        .type-badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 4px;
            background: #e9ecef;
            color: #495057;
        }
    </style>
</head>
<body>

    <?php include('include/header.php'); ?>

    <!-- Modal Edit -->
    <?php if ($edit_data): ?>
    <div class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Modifier l'information de contact #<?= $edit_data['id_contenu'] ?></h3>
                <a href="section_contact.php" class="btn-close-modal"><i class="bi bi-x-lg"></i></a>
            </div>
            <form action="backend/gestion_accueil/edit_contact.php" method="POST">
                <input type="hidden" name="id_contenu" value="<?= $edit_data['id_contenu'] ?>">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label class="form-label">Ordre / Ligne</label>
                        <input type="number" name="lignecontenu" class="form-input" value="<?= $edit_data['lignecontenu'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Valeur Principale (Titre)</label>
                        <textarea name="titre" class="form-input" required><?= htmlspecialchars($edit_data['titre']) ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Sous-titre / Note / URL Carte (Texte)</label>
                    <textarea name="texte" class="form-input" rows="4" required><?= htmlspecialchars($edit_data['texte']) ?></textarea>
                </div>

                <button type="submit" class="btn-submit-modal">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div id="main-content" class="<?= $edit_data ? 'page-blur' : '' ?>">
        
        <!-- Top Navigation -->
        <div class="top-nav-admin">
            <div class="breadcrumb-simple">
                <i class="bi bi-list"></i> Gestion <i class="bi bi-chevron-right" style="font-size: 10px;"></i> <span class="current">Section Contact</span>
            </div>
        </div>

        <!-- Table Info -->
        <div class="table-info-header">
            <div class="table-title-wrap">
                <h1>Informations de Contact</h1>
                <span class="badge-info"><?= $count_rows ?> éléments</span>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>LIGNE</th>
                            <th>TYPE</th>
                            <th>VALEUR PRINCIPALE (TITRE)</th>
                            <th>NOTE / SOUS-TITRE / URL (TEXTE)</th>
                            <th style="text-align: center;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($contact_contents)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #888;">
                                    Aucune donnée disponible.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($contact_contents as $row): ?>
                                <?php
                                    $label = "Autre";
                                    if ($row['lignecontenu'] == 1) $label = "Téléphone";
                                    if ($row['lignecontenu'] == 2) $label = "Email";
                                    if ($row['lignecontenu'] == 3) $label = "Adresse";
                                    if ($row['lignecontenu'] == 4) $label = "Horaires (Lun-Ven)";
                                    if ($row['lignecontenu'] == 5) $label = "Horaires (Samedi)";
                                    if ($row['lignecontenu'] == 6) $label = "Horaires (Dimanche)";
                                    if ($row['lignecontenu'] == 7) $label = "Google Maps Embed";
                                ?>
                                <tr>
                                    <td style="font-weight: 700;"><?= $row['lignecontenu'] ?></td>
                                    <td><span class="type-badge"><?= $label ?></span></td>
                                    <td style="font-weight: 600; color: #1a1a1a; max-width: 250px;"><?= htmlspecialchars($row['titre']) ?></td>
                                    <td style="max-width: 350px; color: #666; font-size: 13px; word-break: break-all;"><?= htmlspecialchars($row['texte']) ?></td>
                                    <td>
                                        <div class="action-links" style="justify-content: center;">
                                            <a href="section_contact.php?edit=<?= $row['id_contenu'] ?>" title="Modifier">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="section_contact.php?delete=<?= $row['id_contenu'] ?>" class="delete" title="Supprimer" onclick="return confirm('Supprimer cet élément ?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section Aperçu (Identique au site réel) -->
        <div class="preview-container" style="margin-top: 40px;">
            <h3 class="preview-title"><i class="bi bi-eye"></i> Aperçu du rendu réel (1:1)</h3>
            
            <div style="background: #f8f9fa; padding: 25px; border-radius: 12px; border: 1px solid #e9ecef;">
                
                <!-- Info strip preview -->
                <section class="info-strip" style="padding: 0; background: transparent;">
                    <div class="row g-3 justify-content-center">
                        <div class="col-lg-4 col-md-6">
                            <div class="info-card">
                                <div class="icon-circle"><i class="bi bi-telephone-fill"></i></div>
                                <h5>Téléphone</h5>
                                <p><a href="tel:<?= $phone ? htmlspecialchars($phone['titre']) : '0322 565 478' ?>"><?= $phone ? htmlspecialchars($phone['titre']) : '0322 565 478' ?></a></p>
                                <p style="margin-top:.2rem;font-size:.78rem;color:#aaa;"><?= $phone ? htmlspecialchars($phone['texte']) : 'Lun–Ven 08h–18h' ?></p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="info-card">
                                <div class="icon-circle"><i class="bi bi-envelope-fill"></i></div>
                                <h5>Email</h5>
                                <p><a href="mailto:<?= $email ? htmlspecialchars($email['titre']) : 'supercar@gmail.com' ?>"><?= $email ? htmlspecialchars($email['titre']) : 'supercar@gmail.com' ?></a></p>
                                <p style="margin-top:.2rem;font-size:.78rem;color:#aaa;"><?= $email ? htmlspecialchars($email['texte']) : 'Réponse sous 24h' ?></p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="info-card">
                                <div class="icon-circle"><i class="bi bi-geo-alt-fill"></i></div>
                                <h5>Adresse</h5>
                                <p><?= $adresse ? htmlspecialchars($adresse['titre']) : 'MCCI Business School, Ebene, Maurice' ?></p>
                                <p style="margin-top:.2rem;font-size:.78rem;color:#aaa;"><?= $adresse ? htmlspecialchars($adresse['texte']) : 'Showroom principal' ?></p>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="row g-4 mt-3">
                    <!-- Horaires preview -->
                    <div class="col-lg-5">
                        <div class="hours-banner">
                            <h5><i class="bi bi-clock-fill"></i> Heures d'ouverture</h5>
                            <div class="hours-row">
                                <span class="hours-day"><?= $lun_ven ? htmlspecialchars($lun_ven['titre']) : 'Lundi – Vendredi' ?></span>
                                <span class="hours-time"><?= $lun_ven ? htmlspecialchars($lun_ven['texte']) : '08h00 – 18h00' ?></span>
                                <span class="open-pill">Ouvert</span>
                            </div>
                            <div class="hours-row">
                                <span class="hours-day"><?= $samedi ? htmlspecialchars($samedi['titre']) : 'Samedi' ?></span>
                                <span class="hours-time"><?= $samedi ? htmlspecialchars($samedi['texte']) : '09h00 – 17h00' ?></span>
                                <span class="open-pill">Ouvert</span>
                            </div>
                            <div class="hours-row">
                                <span class="hours-day"><?= $dimanche ? htmlspecialchars($dimanche['titre']) : 'Dimanche' ?></span>
                                <span class="hours-time closed"><?= $dimanche ? htmlspecialchars($dimanche['texte']) : '10h00 – 15h00' ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Carte Google Maps preview -->
                    <div class="col-lg-7">
                        <div class="map-card">
                            <div class="map-card-header">
                                <h5><i class="bi bi-map-fill"></i> Nous trouver</h5>
                                <p><?= $gmap ? htmlspecialchars($gmap['titre']) : 'MCCI Business School — Showroom principal SUPERCAR' ?></p>
                            </div>

                            <iframe
                                src="<?= $gmap ? htmlspecialchars($gmap['texte']) : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1198.5492211244302!2d57.48494871408381!3d-20.24355594411807!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c5b16955dcd29%3A0xe6719b48c3b7a89a!2sMCCI%20Business%20School!5e0!3m2!1sfr!2smu!4v1700000000000!5m2!1sfr!2smu' ?>"
                                width="100%" style="min-height:300px; border:none; display:block;" loading="lazy"
                                title="Localisation SUPERCAR" allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php include('include/footer.php'); ?>
    
    <!-- Notifications JS -->
    <script src="../assets/js/notifications.js"></script>
    <script>
        <?php if (isset($_SESSION['msg'])): ?>
            showNotification("<?= $_SESSION['msg'] ?>", "success");
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
