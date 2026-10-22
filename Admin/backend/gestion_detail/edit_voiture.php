<?php
include 'fonctionDetail.php';
include '../connexion.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID introuvable.");
}

/*
|--------------------------------------------------------------------------
| RECUPERATION DES DONNEES
|--------------------------------------------------------------------------
*/
$voiture_all = selectAllVoitureAllImage($bdd, $id);

/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/
if (isset($_POST['update'])) {

    $modele            = $_POST['modele'] ?? '';
    $prix              = $_POST['prix'] ?? '';
    $datesortie        = $_POST['datesortie'] ?? '';
    $kilometrage       = $_POST['kilometrage'] ?? '';
    $boite_de_vitesse  = $_POST['boite_de_vitesse'] ?? '';
    $carburant         = $_POST['carburant'] ?? '';
    $puissance         = $_POST['puissance'] ?? '';
    $couleur           = $_POST['couleur'] ?? '';
    $provenance        = $_POST['provenance'] ?? '';
    $details           = $_POST['details'] ?? '';

    /*
    |--------------------------------------------------------------------------
    | UPDATE VOITURE
    |--------------------------------------------------------------------------
    */
    updateVoiture(
        $bdd,
        $id,
        $modele,
        $prix,
        $datesortie,
        $kilometrage,
        $boite_de_vitesse,
        $carburant,
        $puissance,
        $couleur,
        $provenance,
        $details
    );

    /*
    |--------------------------------------------------------------------------
    | AJOUT DES IMAGES
    |--------------------------------------------------------------------------
    */
    if (!empty($_FILES['image']['name'][0])) {

        $upload_dir = __DIR__ . "/../../../images/voiture/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {

            if ($_FILES['image']['error'][$key] === 0) {

                $extension = pathinfo(
                    $_FILES['image']['name'][$key],
                    PATHINFO_EXTENSION
                );

                $new_name = uniqid() . '.' . $extension;

                move_uploaded_file(
                    $tmp_name,
                    $upload_dir . $new_name
                );

                addImageVoiture($bdd, $id, $new_name);
            }
        }
    }

    $success = true;

    // Refresh data
    $voiture_all = selectAllVoitureAllImage($bdd, $id);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier voiture</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/header.css">
    <link rel="stylesheet" href="../../assets/index.css">
    <link rel="stylesheet" href="../../assets/service3.css">
</head>

<body>

<?php include('../../include/header.php'); ?>

<div id="main-content">

    <div class="form-card">

        <a href="../../liste_voiture.php" class="btn-retour">
            <i class="bi bi-arrow-left"></i>
            Retour
        </a>

        <h1>
            <i class="bi bi-pencil-square"></i>
            Modifier voiture
        </h1>

        <p class="subtitle">
            Modifiez les informations du véhicule.
        </p>

        <?php if (!empty($success)) : ?>
            <div class="alert-success">
                <i class="bi bi-check-circle-fill"></i>
                Voiture modifiée avec succès.
            </div>
        <?php endif; ?>

        <?php foreach ($voiture_all as $v) : ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="form-grid">

                    <div class="form-group">
                        <label>
                            <i class="bi bi-car-front"></i>
                            Modèle
                        </label>

                        <input
                            type="text"
                            name="modele"
                            value="<?= htmlspecialchars($v['modele']) ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="bi bi-cash-coin"></i>
                            Prix
                        </label>

                        <input
                            type="number"
                            name="prix"
                            value="<?= htmlspecialchars($v['prix']) ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="bi bi-calendar-event"></i>
                            Date de sortie
                        </label>

                        <input
                            type="date"
                            name="datesortie"
                            value="<?= htmlspecialchars($v['datesortie']) ?>">
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="bi bi-speedometer2"></i>
                            Kilométrage
                        </label>

                        <input
                            type="number"
                            name="kilometrage"
                            value="<?= htmlspecialchars($v['kilometrage']) ?>">
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="bi bi-gear"></i>
                            Boîte de vitesse
                        </label>

                        <input
                            type="text"
                            name="boite_de_vitesse"
                            value="<?= htmlspecialchars($v['boite_de_vitesse']) ?>">
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="bi bi-fuel-pump"></i>
                            Carburant
                        </label>

                        <input
                            type="text"
                            name="carburant"
                            value="<?= htmlspecialchars($v['carburant']) ?>">
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="bi bi-lightning-charge"></i>
                            Puissance
                        </label>

                        <input
                            type="text"
                            name="puissance"
                            value="<?= htmlspecialchars($v['puissance']) ?>">
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="bi bi-palette"></i>
                            Couleur
                        </label>

                        <input
                            type="text"
                            name="couleur"
                            value="<?= htmlspecialchars($v['couleur']) ?>">
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="bi bi-globe"></i>
                            Provenance
                        </label>

                        <input
                            type="text"
                            name="provenance"
                            value="<?= htmlspecialchars($v['provenance']) ?>">
                    </div>

                    <div class="form-group full">
                        <label>
                            <i class="bi bi-text-paragraph"></i>
                            Détails
                        </label>

                        <textarea name="details"><?= htmlspecialchars($v['details']) ?></textarea>
                    </div>

                    <!-- AJOUT IMAGE -->
                    <div class="form-group full" onclick = "openImageAjout()">

                        <label>
                            <i class="bi bi-cloud-arrow-up"></i>
                            Ajouter des images
                        </label>

                    </div>

                    <!-- IMAGES ACTUELLES -->
                    <div class="form-group full">

                        <label>
                            <i class="bi bi-images"></i>
                            Images actuelles
                        </label>

                        <div style="
                            display:flex;
                            gap:15px;
                            flex-wrap:wrap;
                            margin-top:15px;
                        ">

                            <?php if (!empty($v['images'])) : ?>

                                <?php foreach ($v['images'] as $img) : ?>

                                    <img
                                        src="../../../images/voiture/<?= $img['url_image'] ?>"
                                        style="
                                            width:120px;
                                            height:120px;
                                            object-fit:cover;
                                            border-radius:10px;
                                            cursor:pointer;
                                            border:1px solid #ccc;
                                        "
                                        onclick="openEditImage(
                                            <?= $img['id_image'] ?>,
                                            <?= $img['priorite'] ?>,
                                            '<?= $img['url_image'] ?>'
                                        )">

                                <?php endforeach; ?>

                            <?php else : ?>

                                <div class="empty-image">
                                    <i class="bi bi-image-alt"></i>
                                    Pas d'image
                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <div class="divider"></div>

                <button type="submit" name="update" class="btn-submit">
                    <i class="bi bi-check2-circle"></i>
                    Modifier la voiture
                </button>

            </form>

        <?php endforeach; ?>

    </div>
</div>

<!-- AJOUT IMAGE -->
<div id="imageAjout" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
">

    <div style="background:#fff;padding:20px;border-radius:10px;width:350px;position:relative;">

        <h4>
            <i class="bi bi-image"></i>
            Ajouter image
        </h4>

        <form
            method="POST"
            enctype="multipart/form-data"
            action="insertion_image.php">


            <div class="form-group">
                <label>Nouvelle image</label>
                <input type="file" name="new_image">
                <input type="hidden" name="idvoiture" value="<?= htmlspecialchars($id) ?>">
            </div>

            <div class="form-group">
                <label>Priorité</label>
                <input type="number" name="priorite">
            </div>

            <button type="submit" class="btn-submit" onclick="SauvegardeImage()">
                <i class="bi bi-check-circle"></i>
                Sauvegarder
            </button>

        </form>

        <button
            onclick="closeImageAjout()"
            style="
                position:absolute;
                top:10px;
                right:10px;
                border:none;
                background:none;
                font-size:18px;
                cursor:pointer;
            ">
            ✖
        </button>

    </div>

</div>

<!-- MODAL IMAGE -->
<div id="imageModal" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
">

    <div style="background:#fff;padding:20px;border-radius:10px;width:350px;position:relative;">

        <h4>
            <i class="bi bi-image"></i>
            Modifier image
        </h4>

        <form
            method="POST"
            enctype="multipart/form-data"
            action="update_Image.php">

            <input type="hidden" name="id_image" id="id_image">

            <div style="text-align:center; margin-bottom:15px;">
                <img
                    id="previewImage"
                    style="
                        width:120px;
                        height:120px;
                        object-fit:cover;
                        border-radius:10px;
                    ">
            </div>

            <div class="form-group">
                <label>Nouvelle image</label>
                <input type="file" name="new_image">
                <input type="hidden" name="idvoiture" value="<?= htmlspecialchars($id) ?>">
            </div>

            <div class="form-group">
                <label>Priorité</label>
                <input type="number" name="priorite" id="priorite">
            </div>

            <button type="submit" class="btn-submit" onclick="SauvegardeImage()">
                <i class="bi bi-check-circle"></i>
                Sauvegarder
            </button>

        </form>

        <button
            onclick="closeModal()"
            style="
                position:absolute;
                top:10px;
                right:10px;
                border:none;
                background:none;
                font-size:18px;
                cursor:pointer;
            ">
            ✖
        </button>

    </div>

</div>

<?php include('../../include/footer.php'); ?>

<script>

function openEditImage(id, priorite, image) {

    document.getElementById('imageModal').style.display = 'flex';

    document.getElementById('id_image').value = id;
    document.getElementById('priorite').value = priorite;
    document.getElementById('previewImage').src = '../../../images/voiture/' + image;
}

function closeModal() {

    document.getElementById('imageModal').style.display = 'none';
}

function openImageAjout(id, priorite, image) {

    document.getElementById('imageAjout').style.display = 'flex';
}

function closeImageAjout() {

    document.getElementById('imageAjout').style.display = 'none';
}
</script>

</body>
</html>