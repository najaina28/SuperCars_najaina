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
    header("Location: section_hero.php");
    exit();
}

// Récupération des données
$hero_contents = get_contenu_by_page('accueil');
$count_rows = count($hero_contents);

// Récupération du contenu à modifier (si demandé)
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_data = get_contenu_by_id($edit_id);
}

// Pour l'aperçu (ligne 1)
$hero_main = null;
foreach ($hero_contents as $row) {
    if ($row['lignecontenu'] == 1) $hero_main = $row;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables > contenu - Supercar Admin</title>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Style -->
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/section_hero.css">
</head>
<body>

    <?php include('include/header.php'); ?>

    <!-- Modal Edit -->
    <?php if ($edit_data): ?>
    <div class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Modifier la ligne #<?= $edit_data['id_contenu'] ?></h3>
                <a href="section_hero.php" class="btn-close-modal"><i class="bi bi-x-lg"></i></a>
            </div>
            <form action="backend/gestion_accueil/edit_hero.php" method="POST" enctype="multipart/form-data">
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

                <div class="form-group">
                    <label class="form-label">Image de fond (Hero)</label>
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <?php if($edit_data['image']): ?>
                            <img src="../SiteWeb/assets/images/<?= $edit_data['image'] ?>" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover; border: 1px solid #ddd;">
                        <?php endif; ?>
                        <input type="file" name="image" class="form-input" style="padding: 8px;">
                    </div>
                </div>

                <button type="submit" class="btn-submit-modal">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div id="main-content" class="<?= $edit_data ? 'page-blur' : '' ?>">
        
        <!-- Top Navigation (Breadcrumb) -->
        <div class="top-nav-admin">
            <div class="breadcrumb-simple">
                <i class="bi bi-list"></i> Gestion <i class="bi bi-chevron-right" style="font-size: 10px;"></i> <span class="current">contenu</span>
            </div>
        </div>

        <!-- Table Info -->
        <div class="table-info-header">
            <div class="table-title-wrap">
                <h1>contenu</h1>
                <span class="badge-info"><?= $count_rows ?> lignes</span>
                <span class="badge-info">6 colonnes</span>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>IDCONTENT <span class="cell-badge">PK</span></th>
                            <th>IMAGE</th>
                            <th>TITRE</th>
                            <th>TEXTE</th>
                            <th style="text-align: center;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($hero_contents)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #888;">
                                    Aucune donnée disponible.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($hero_contents as $row): ?>
                                <tr>
                                    <td style="font-weight: 700;"><?= $row['id_contenu'] ?></td>
                                    <td>
                                        <?php if($row['image']): ?>
                                            <div style="width: 40px; height: 40px; border-radius: 4px; background: url('../SiteWeb/assets/images/<?= $row['image'] ?>') center/cover;"></div>
                                        <?php else: ?>
                                            <div style="width: 40px; height: 40px; border-radius: 4px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #ccc;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-weight: 600; color: #1a1a1a;"><?= $row['titre'] ?></td>
                                    <td style="max-width: 300px; color: #666; font-size: 13px;"><?= $row['texte'] ?></td>
                                    <td>
                                        <div class="action-links" style="justify-content: center;">
                                            <a href="section_hero.php?edit=<?= $row['id_contenu'] ?>" title="Modifier">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="backend/gestion_accueil/delete_hero.php?id=<?= $row['id_contenu'] ?>" class="delete" title="Supprimer" onclick="return confirm('Supprimer définitivement cette ligne ?')">
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

        <!-- Section Aperçu -->
        <div class="preview-container">
            <h3 class="preview-title"><i class="bi bi-eye"></i> Aperçu du rendu réel (1:1)</h3>
            <div class="hero-preview-wrapper">
                <section class="hero-section" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('../SiteWeb/assets/images/<?= $hero_main['image'] ?? 'background/porsche.jpg' ?>') center/cover;">
                    <div class="hero-overlay"></div>
                    <div class="hero-content">
                        <h1 class="hero-title"><?= $hero_main ? $hero_main['titre'] : "Titre par défaut" ?></h1>
                        <div class="btn-orange-hero"><?= $hero_main ? $hero_main['texte'] : "Bouton" ?></div>
                    </div>
                </section>
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
