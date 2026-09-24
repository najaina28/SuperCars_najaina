<?php
session_start();
include 'fonctionsProfil.php';

// Vérifier si le client est connecté
if (!isset($_SESSION['id_client']) || empty($_SESSION['id_client'])) {
    header('location: ../login.php');
    exit();
}

$id_client = $_SESSION['id_client'];

// Traitement de la modification des informations
if (isset($_POST['action']) && $_POST['action'] == 'modifier_infos') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    if (modifierClient($id_client, $nom, $prenom, $mail, $telephone, $adresse)) {
        // Mettre à jour la session avec les nouvelles infos
        $_SESSION['nom']       = $nom;
        $_SESSION['prenom']    = $prenom;
        $_SESSION['mail']      = $mail;
        $_SESSION['telephone'] = $telephone;

        header('location: ../profil.php?succes=modif');
        exit();
    } else {
        header('location: ../profil.php?erreur=modif');
        exit();
    }

} else {
    header('location: ../profil.php');
    exit();
}
?>