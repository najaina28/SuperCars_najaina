<?php
session_start();
require_once __DIR__ . '/../connexion.php';
require_once __DIR__ . '/fonctionDetail.php';

$id_image  = $_GET['id_image'] ?? null;
$idvoiture = $_GET['idvoiture'] ?? null;

if ($id_image) {
    deleteImage($bdd, $id_image);
    $_SESSION['msg'] = "Image supprimée.";
}

if ($idvoiture) {
    header("Location: edit_voiture.php?id=" . $idvoiture);
} else {
    header("Location: ../../liste_voiture.php");
}
exit;
?>
