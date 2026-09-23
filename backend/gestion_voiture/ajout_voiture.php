<?php
session_start();
require_once __DIR__ . '/../gestion_detail/fonctionDetail.php';
require_once __DIR__ . '/../connexion.php';

$marques = getAllMarques($bdd);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une voiture - Admin Supercar</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="../../assets/header.css">
    <link rel="stylesheet" href="../../assets/index.css">
    <link rel="stylesheet" href="../../assets/service-edit.css">
    <!-- Notifications -->
    <link rel="stylesheet" href="../../../Site web/assets/css/notifications.css">
    <style>
        .image-preview-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .preview-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<?php include('../../include/header.php'); ?>

<div id="main-content">
    <div class="form-card">

        <a href="../../liste_voiture.php" class="btn-retour">
            <i class="bi bi-arrow-left"></i>
            Retour
        </a>

        <h1><i class="bi bi-plus-circle"></i> Ajouter une voiture</h1>
        <p class="subtitle">Remplissez les informations ci-dessous pour ajouter un nouveau véhicule au catalogue.</p>

        <?php if (isset($_SESSION['msg'])): ?>
            <div style="background: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <?= $_SESSION['msg'] ?>
                <?php unset($_SESSION['msg']); ?>
            </div>
        <?php endif; ?>

        <form action="traitement_ajout_voiture.php" method="POST" enctype="multipart/form-data">

            <div class="form-grid">

                <div class="form-group">
                    <label for="id_marque"><i class="bi bi-tag"></i> Marque</label>
                    <select id="id_marque" name="id_marque" required>
                        <option value="">Sélectionner une marque</option>
                        <?php foreach($marques as $marque): ?>
                            <option value="<?= $marque['id_marque'] ?>"><?= $marque['nom_marque'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="modele"><i class="bi bi-car-front"></i> Modèle</label>
                    <input type="text" id="modele" name="modele" placeholder="Ex : 911 GT3 RS" required>
                </div>

                <div class="form-group">
                    <label for="prix"><i class="bi bi-currency-euro"></i> Prix (€)</label>
                    <input type="number" id="prix" name="prix" placeholder="Ex : 235000" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="datesortie"><i class="bi bi-calendar-date"></i> Date de sortie</label>
                    <input type="date" id="datesortie" name="datesortie" required>
                </div>

                <div class="form-group">
                    <label for="kilometrage"><i class="bi bi-speedometer2"></i> Kilométrage</label>
                    <input type="number" id="kilometrage" name="kilometrage" placeholder="Ex : 500" min="0" required>
                </div>

                <div class="form-group">
                    <label for="boite_de_vitesse"><i class="bi bi-gear"></i> Boîte de vitesse</label>
                    <input type="text" id="boite_de_vitesse" name="boite_de_vitesse" placeholder="Ex : Automatique PDK" required>
                </div>

                <div class="form-group">
                    <label for="carburant"><i class="bi bi-fuel-pump"></i> Carburant</label>
                    <input type="text" id="carburant" name="carburant" placeholder="Ex : Essence" required>
                </div>

                <div class="form-group">
                    <label for="puissance"><i class="bi bi-lightning-charge"></i> Puissance (ch)</label>
                    <input type="number" id="puissance" name="puissance" placeholder="Ex : 525">
                </div>

                <div class="form-group">
                    <label for="couleur"><i class="bi bi-palette"></i> Couleur</label>
                    <input type="text" id="couleur" name="couleur" placeholder="Ex : Rouge Indien">
                </div>

                <div class="form-group">
                    <label for="provenance"><i class="bi bi-geo-alt"></i> Provenance</label>
                    <input type="text" id="provenance" name="provenance" placeholder="Ex : Allemagne">
                </div>

                <div class="form-group full">
                    <label for="details"><i class="bi bi-text-paragraph"></i> Détails / Description</label>
                    <textarea id="details" name="details" placeholder="Description détaillée du véhicule…" required></textarea>
                </div>

                <div class="form-group full">
                    <label><i class="bi bi-images"></i> Images de la voiture</label>
                    <div class="upload-zone" id="uploadZone">
                        <input type="file" name="images[]" id="images" accept="image/*" multiple onchange="previewImages(this)">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Glissez vos images ici ou cliquez pour parcourir</span>
                        <p style="font-size: 0.8rem; color: #666; margin-top: 5px;">La première image sera l'image principale.</p>
                        <div id="imagePreview" class="image-preview-container"></div>
                    </div>
                </div>

            </div>

            <div class="divider"></div>

            <button type="submit" name="ajouter" class="btn-submit">
                <i class="bi bi-check2-circle"></i>
                Ajouter la voiture
            </button>

        </form>
    </div>
</div>

<?php include('../../include/footer.php'); ?>

<!-- Notifications -->
<script src="../../../Site web/assets/js/notifications.js"></script>
<script src="../../../Site web/assets/js/supercar.js"></script>
<script>
    function previewImages(input) {
        const previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = '';

        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('preview-img');
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>

</body>
</html>
