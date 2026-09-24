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
        $_SESSION['msg'] = "Ligne supprimée.";
    }
    header("Location: section_apropos.php");
    exit();
}

// Récupération des données
$apropos_contents = get_contenu_by_page('apropos');
$count_rows = count($apropos_contents);

// Récupération du contenu à modifier
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_data = get_contenu_by_id($edit_id);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion À propos - Supercar Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/section_hero.css">
    <link rel="stylesheet" href="assets/section_apropos.css">
</head>
<body>

    <?php include('include/header.php'); ?>

    <!-- Modal Edit -->
    <?php if ($edit_data): ?>
    <div class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Modifier À propos #<?= $edit_data['id_contenu'] ?></h3>
                <a href="section_apropos.php" class="btn-close-modal"><i class="bi bi-x-lg"></i></a>
            </div>
            <form action="backend/gestion_accueil/edit_apropos.php" method="POST">
                <input type="hidden" name="id_contenu" value="<?= $edit_data['id_contenu'] ?>">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label class="form-label">Ordre / Ligne</label>
                        <input type="number" name="lignecontenu" class="form-input" value="<?= $edit_data['lignecontenu'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Titre</label>
                        <textarea name="titre" class="form-input" required><?= $edit_data['titre'] ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Texte / Description</label>
                    <textarea name="texte" class="form-input" rows="3" required><?= $edit_data['texte'] ?></textarea>
                </div>


                <button type="submit" class="btn-submit-modal">Enregistrer</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div id="main-content" class="<?= $edit_data ? 'page-blur' : '' ?>">
        
        <div class="top-nav-admin">
            <div class="breadcrumb-simple">
                <i class="bi bi-list"></i> Gestion <i class="bi bi-chevron-right" style="font-size: 10px;"></i> <span class="current">À propos</span>
            </div>
        </div>

        <div class="table-info-header">
            <div class="table-title-wrap">
                <h1>Section À propos</h1>
                <span class="badge-info"><?= $count_rows ?> éléments</span>
            </div>
        </div>

        <div class="table-container">
            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>LIGNE</th>
                            <th>TITRE</th>
                            <th>TEXTE</th>
                            <th style="text-align: center;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($apropos_contents)): ?>
                            <tr><td colspan="5" style="text-align: center; padding: 40px;">Aucune donnée.</td></tr>
                        <?php else: ?>
                            <?php foreach ($apropos_contents as $row): ?>
                                <tr>
                                    <td><?= $row['lignecontenu'] ?></td>
                                    <td style="font-weight: 600;"><?= $row['titre'] ?></td>
                                    <td style="font-size: 13px; color: #666;"><?= $row['texte'] ?></td>
                                    <td>
                                        <div class="action-links" style="justify-content: center;">
                                            <a href="section_apropos.php?edit=<?= $row['id_contenu'] ?>"><i class="bi bi-pencil-square"></i></a>
                                            <a href="backend/gestion_accueil/delete_apropos.php?id=<?= $row['id_contenu'] ?>" class="delete" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section Aperçu (Identique au site) -->
        <div class="preview-container">
            <h3 class="preview-title"><i class="bi bi-eye"></i> Aperçu du rendu réel</h3>
            
            <div class="apropos-preview-wrapper">
                <section class="about-section">
                    <div class="container py-5">
                        <?php 
                            $main = null;
                            foreach ($apropos_contents as $c) {
                                if ($c['lignecontenu'] == 1) {
                                    $main = $c;
                                    break;
                                }
                            }
                        ?>
                        <div class="text-center mb-5">
                            <h2 class="section-title"><?= $main ? $main['titre'] : "À propos de SuperCar" ?></h2>
                            <p class="section-description"><?= $main ? $main['texte'] : "Depuis 2009, SuperCar est votre partenaire de confiance dans l'acquisition de voitures d'occasionss." ?></p>
                        </div>

                        <div class="row g-4 justify-content-center">
                            <?php foreach ($apropos_contents as $item): ?>
                                <?php if ($item['lignecontenu'] > 1): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="info-card">
                                        <div class="info-icon-wrap">
                                            <?php 
                                                $icon = "bi-check-circle";
                                                if ($item['lignecontenu'] == 2) $icon = "bi-globe";
                                                if ($item['lignecontenu'] == 3) $icon = "bi-houses-fill";
                                                if ($item['lignecontenu'] == 4) $icon = "bi-shop";
                                            ?>
                                            <i class="bi <?= $icon ?>"></i>
                                        </div>
                                        <h3 class="info-card-title"><?= $item['titre'] ?></h3>
                                        <p class="info-card-text"><?= $item['texte'] ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>

    <?php include('include/footer.php'); ?>
    
    <script src="../assets/js/notifications.js"></script>
    <script>
        <?php if (isset($_SESSION['msg'])): ?>
            showNotification("<?= $_SESSION['msg'] ?>", "success");
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
