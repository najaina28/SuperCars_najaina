<?php 
include 'fonctionDetail.php';
include '../connexion.php';

$id = $_GET['id'];

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: liste_voiture.php");
    exit();
}

$id = (int) $_GET['id'];


deleteVoiture($bdd,$id);

header("Location: ../../liste_voiture.php?succes=delete");
exit();



?>