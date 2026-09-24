<?php
if (file_exists('backend/connexion.php')) include 'backend/connexion.php';
else if (file_exists('../connexion.php')) include '../connexion.php';
include("FonctionDemande.php");

$id = $_POST['id_demande'];
$statut = $_POST['statut'];

updateStatutDemande($bdd, $id, $statut);

// redirection
header("Location: ../../demande_essaie.php");
exit;

?>