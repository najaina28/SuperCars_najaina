<?php
session_start();

// Vérification des données POST
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header('location: ../loginAdmin.php');
    exit();
}

// Inclusion de la connexion DB
include 'connexion.php';

$email    = mysqli_real_escape_string($bdd, $_POST['email']);
$password = $_POST['password'];

// Récupérer l'admin par email depuis la table 'admin'
$sql = "SELECT * FROM admin WHERE mail = '$email'";
$result = mysqli_query($bdd, $sql);
$admin = mysqli_fetch_assoc($result);

if ($admin) {
    // Vérifier le mot de passe
    if (password_verify($password, $admin['mot_de_passe']) || $admin['mot_de_passe'] == $password) {
        // Connexion réussie : on initialise la session
        $_SESSION['id_admin']  = $admin['id_admin'];
        $_SESSION['prenom']    = $admin['prenom'];
        $_SESSION['nom']       = $admin['nom'];
        $_SESSION['mail']      = $admin['mail'];
        $_SESSION['role']      = 'admin';

        // Redirection vers le tableau de bord Admin
        header('location: ../tableauBord.php?succes=connexion');
        exit();
    } else {
        // Mot de passe incorrect
        header('location: ../loginAdmin.php?erreur=mdp');
        exit();
    }
} else {
    // Email introuvable
    header('location: ../loginAdmin.php?erreur=email');
    exit();
}
?>
