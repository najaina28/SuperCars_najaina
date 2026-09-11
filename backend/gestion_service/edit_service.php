<?php
include 'fonctionService.php';

$id = $_GET['id'];

$services = getAllService($bdd);


$sql = "SELECT * FROM service WHERE id_service = ?";
$stmt = $bdd->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$service = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $id = $_GET['id'];
    $nom = $_POST['nom_service'];
    $titre = $_POST['titre_service'];
    $description = $_POST['description_service'];
    $prix = $_POST['prix_service'];

    $image_name = null; // par défaut on ne change PAS l'image

    //Seulement si une image est envoyée
    if (!empty($_FILES['image_service']) && $_FILES['image_service']['error'] === 0) {

        $upload_dir = __DIR__ . "/uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $ext = pathinfo($_FILES['image_service']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid() . "." . $ext;

        move_uploaded_file(
            $_FILES['image_service']['tmp_name'],
            $upload_dir . $image_name
        );
    }

    updateService($id, $nom, $titre, $description, $prix, $image_name);

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un service - Admin Supercar</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="../../assets/header.css">
    <link rel="stylesheet" href="../../assets/index.css">
    <link rel="stylesheet" href="../../assets/service3.css">

</head>
<body>

<?php include('../../include/header.php'); ?>

<div id="main-content">
    <div class="form-card">

        <a href="../../liste_service.php" class="btn-retour">
        <i class="bi bi-arrow-left"></i>
        Retour
        </a>
        
        <h1><i class="bi bi-plus-circle"></i> Modifier un service</h1>
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
                    <input type="text" id="nom_service" name="nom_service" value="<?php echo $service['nom_service']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="titre_service"><i class="bi bi-card-heading"></i> Titre</label>
                    <input type="text" id="titre_service" name="titre_service" value="<?= $service['titre_service'] ?>"required>
                </div>

                <div class="form-group">
                    <label for="prix_service"><i class="bi bi-currency-euro"></i> Prix (€)</label>
                    <input type="number" id="prix_service" name="prix_service" value="<?= $service['prix_service'] ?>" required>
                </div>

                <div class="form-group full">
                    <label for="description_service"><i class="bi bi-text-paragraph"></i> Description</label>
                    <textarea name="description_service" required><?= $service['description_service'] ?></textarea>                </div>

                    <div class="form-group full" style="display:flex; gap:20px; align-items:center;">

                <!-- Zone upload -->
                <div style="flex:1;">
                    <label><i class="bi bi-image"></i> Image du service</label>
                    <div class="upload-zone" id="uploadZone">
                        <input type="file" name="image_service" id="image_service" accept="image/*" onchange="updateFileName(this)">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Glissez une image ici ou cliquez pour parcourir</span>
                        <div class="file-name" id="fileName"></div>
                    </div>
                </div>

                <!-- Image actuelle -->
                <div style="width:150px; text-align:center;">
                    <label>Image actuelle</label><br>

                    <?php if (!empty($service['image_service'])) { ?>
                        <img src="uploads/<?php echo $service['image_service']; ?>" 
                            style="width:120px; height:120px; object-fit:cover; border-radius:10px; border:1px solid #ccc;">
                    <?php } else { ?>
                        <div style="width:120px; height:120px; display:flex; align-items:center; justify-content:center; border:1px dashed #ccc; border-radius:10px;">
                            Pas d'image
                        </div>
                    <?php } ?>
                </div>

                </div>

            </div>

            <div class="divider"></div>

            <button type="submit" name="update" class="btn-submit">
                <i class="bi bi-check2-circle"></i>
                Mofifier le service
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
