<?php

include '../connexion.php';
include 'fonctionDetail.php';

$idvoiture = $_POST['idvoiture'];
$priorite  = $_POST['priorite'];


if (!empty($_FILES['new_image']['name'])) {

    $upload_dir = __DIR__ . "/../../../images/voiture/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $extension = pathinfo($_FILES['new_image']['name'], PATHINFO_EXTENSION);

    $new_name = uniqid() . "." . $extension;

    move_uploaded_file(
        $_FILES['new_image']['tmp_name'],
        $upload_dir . $new_name
    );

    insertImage($bdd, $new_name, $idvoiture, $priorite);
}


header("Location: edit_voiture.php?id=" . $idvoiture);
exit;
?>