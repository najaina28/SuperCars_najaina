<?php
session_start();
require_once __DIR__ . '/../gestion_detail/fonctionDetail.php';
require_once __DIR__ . '/../connexion.php';

if (isset($_POST['ajouter'])) {

    $modele            = $_POST['modele'] ?? '';
    $prix              = $_POST['prix'] ?? 0;
    $datesortie        = $_POST['datesortie'] ?? '';
    $kilometrage       = $_POST['kilometrage'] ?? 0;
    $boite_de_vitesse  = $_POST['boite_de_vitesse'] ?? '';
    $carburant         = $_POST['carburant'] ?? '';
    $puissance         = $_POST['puissance'] ?? '';
    $couleur           = $_POST['couleur'] ?? '';
    $provenance        = $_POST['provenance'] ?? '';
    $details           = $_POST['details'] ?? '';
    $id_marque         = $_POST['id_marque'] ?? null;
    $disponibilite     = 1;

    if ($id_marque) {
        $id_voiture = insertionVoiture(
            $bdd,
            $modele,
            $prix,
            $datesortie,
            $kilometrage,
            $boite_de_vitesse,
            $carburant,
            $puissance,
            $couleur,
            $provenance,
            $details,
            $id_marque,
            $disponibilite
        );

        if ($id_voiture) {
            // AJOUT DES IMAGES
            if (!empty($_FILES['images']['name'][0])) {
                $upload_dir = __DIR__ . "/../../../images/voiture/";
                
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['images']['error'][$key] === 0) {
                        $extension = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
                        $new_name = uniqid() . '.' . $extension;

                        if (move_uploaded_file($tmp_name, $upload_dir . $new_name)) {
                            $priorite = ($key === 0) ? 1 : 0;
                            insertImage($bdd, $new_name, $id_voiture, $priorite);
                        }
                    }
                }
            }
            $_SESSION['msg'] = "Voiture ajoutée avec succès !";
            header("Location: ../../liste_voiture.php");
            exit();
        } else {
            $_SESSION['msg'] = "Erreur lors de l'ajout de la voiture.";
        }
    } else {
        $_SESSION['msg'] = "Veuillez sélectionner une marque.";
    }
}

header("Location: ajout_voiture.php");
exit();
?>
