<?php

include 'fonctionsLogin.php';

// 1. Vérification du Captcha
$valid_cars = ['voiture1.jpg', 'voiture2.jpg', 'voiture3.jpg', 'voiture4.jpg'];
$is_valid_captcha = true;

if (!isset($_POST['captcha']) || count($_POST['captcha']) != 4) {
    $is_valid_captcha = false;
} else {
    foreach ($_POST['captcha'] as $selected_img) {
        if (!in_array($selected_img, $valid_cars)) {
            $is_valid_captcha = false;
            break;
        }
    }
}

if (!$is_valid_captcha) {
    // Redirection vers login avec l'erreur captcha
    header('location: ../login.php?erreur=captcha');
    exit();
}

// 2. Traitement du login
$email = $_POST['email'];
$password = $_POST['password'];

$client = getClientByEmail($email);

if ($client) {
    if (verifierMotDePasse($password, $client['mot_de_passe'])) {
        session_start();
        $_SESSION['id_client'] = $client['id_client'];
        $_SESSION['prenom']    = $client['prenom'];
        $_SESSION['nom']       = $client['nom'];
        $_SESSION['mail']      = $client['mail'];
        $_SESSION['telephone'] = $client['telephone'];
        $_SESSION['role']      = $client['role'];
        header('location: ../profil.php?succes=login');
        exit();

    } else {
        header('location: ../login.php?erreur=mdp');
        exit();
    }
} else {
    header('location: ../login.php?erreur=email');
    exit();
}

?>