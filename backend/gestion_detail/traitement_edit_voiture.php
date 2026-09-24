<?php
session_start();
require_once __DIR__ . '/fonctionDetail.php';
require_once __DIR__ . '/../connexion.php';

if (isset($_POST['update'])) {

    $id                = $_POST['idvoiture'];
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

    // AJOUT DES IMAGES
    if (!empty($_FILES['image']['name'][0])) {
        $upload_dir = __DIR__ . "/../../../Site web/assets/images/";
        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['image']['error'][$key] === 0) {
                $extension = pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION);
                $new_name = uniqid() . '.' . $extension;
                move_uploaded_file($tmp_name, $upload_dir . $new_name);
                addImageVoiture($bdd, $id, $new_name);
            }
        }
    }

    $_SESSION['msg'] = "Voiture modifiée avec succès.";
    header("Location: edit_voiture.php?id=" . $id);
    exit();
}

header("Location: ../../liste_voiture.php");
exit();
?>
