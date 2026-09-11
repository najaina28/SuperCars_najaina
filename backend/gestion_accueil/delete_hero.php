<?php
session_start();
include 'FonctionContenu.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if (supprimer_contenu($id)) {
        $_SESSION['msg'] = "Ligne supprimée.";
    }
}

header("Location: ../../section_hero.php");
exit();
?>
