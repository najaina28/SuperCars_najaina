<?php 
include 'fonctionService.php';

$id = $_GET['id'];

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: liste_service.php");
    exit();
}

$id = (int) $_GET['id'];


deleteService($id);

header("Location: ../../liste_service.php?succes=delete");
exit();



?>