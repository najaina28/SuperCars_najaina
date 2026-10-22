<?php
include 'fonctionService.php';

if (isset($_POST['ajouter'])) {

    $nom = $_POST['nom_service'];
    $titre = $_POST['titre_service'];
    $description = $_POST['description_service'];
    $prix = $_POST['prix_service'];

    $tmp_name = $_FILES['image_service']['tmp_name'];
    $original_name = time() . "_" . $_FILES['image_service']['name'];

    $upload_dir = __DIR__ . "/../../../images/service/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (!move_uploaded_file($tmp_name, $upload_dir . $original_name)) {
        die("Erreur lors de l'upload de l'image");
    }

    insertionService($nom, $titre, $description, $prix, $original_name);

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un service - Admin Supercar</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="../../assets/header.css">
    <link rel="stylesheet" href="../../assets/index.css">
    <link rel="stylesheet" href="../../assets/service-edit.css">

</head>
<body>

<?php include('../../include/header.php'); ?>

<div id="main-content">
    <div class="form-card">

        <a href="../../liste_service.php" class="btn-retour">
        <i class="bi bi-arrow-left"></i>
        Retour
        </a>

        <h1><i class="bi bi-plus-circle"></i> Ajouter un service</h1>
        <p class="subtitle">Remplissez les informations ci-dessous pour publier un nouveau service dans le catalogue.</p>

        <?php if (!empty($success)): ?>
            <div class="alert-success">
                <i class="bi bi-check-circle-fill"></i>
                Service ajouté avec succès.
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <div class="form-grid">

                <div class="form-group">
                    <label for="nom_service"><i class="bi bi-tag"></i> Nom du service</label>
                    <input type="text" id="nom_service" name="nom_service" placeholder="Ex : Entretien Premium" required>
                </div>

                <div class="form-group">
                    <label for="titre_service"><i class="bi bi-card-heading"></i> Titre</label>
                    <input type="text" id="titre_service" name="titre_service" placeholder="Ex : Révision complète" required>
                </div>

                <div class="form-group">
                    <label for="prix_service"><i class="bi bi-currency-euro"></i> Prix (€)</label>
                    <input type="number" id="prix_service" name="prix_service" placeholder="Ex : 299" min="0" step="0.01" required>
                </div>

                <div class="form-group full">
                    <label for="description_service"><i class="bi bi-text-paragraph"></i> Description</label>
                    <textarea id="description_service" name="description_service" placeholder="Décrivez le service en quelques lignes…" required></textarea>
                </div>

                <div class="form-group full">
                    <label><i class="bi bi-image"></i> Image du service</label>
                    <div class="upload-zone" id="uploadZone">
                        <input type="file" name="image_service" id="image_service" accept="image/*" onchange="updateFileName(this)">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Glissez une image ici ou cliquez pour parcourir</span>
                        <div class="file-name" id="fileName"></div>
                    </div>
                </div>

            </div>

            <div class="divider"></div>

            <button type="submit" name="ajouter" class="btn-submit">
                <i class="bi bi-check2-circle"></i>
                Ajouter le service
            </button>

        </form>
    </div>
</div>

<?php include('../../include/footer.php'); ?>

<script>
    function updateFileName(input) {
        const label = document.getElementById('fileName');
        if (input.files && input.files[0]) {
            label.textContent = '📎 ' + input.files[0].name;
        } else {
            label.textContent = '';
        }
    }
</script>

</body>
</html>
