<?php

include 'fonctionsInscription.php';

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Vérification des conditions
if (!isset($_POST['conditions'])) {
    header('location: ../inscription.php?erreur=conditions');
    exit();
}

if ($password != $confirm_password) {
    header('location: ../inscription.php?erreur=mdp');
    exit();
}

if (emailExiste($email)) {
    header('location: ../inscription.php?erreur=email');
    exit();
}

inscrireClient($nom, $prenom, $email, $telephone, $password);
header('location: ../login.php?succes=inscription');
exit();

?>