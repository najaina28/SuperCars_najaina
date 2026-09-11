<?php
session_start();
include 'FonctionContenu.php';

if (isset($_POST['id_contenu'])) {
    $id    = $_POST['id_contenu'];
    $ligne = $_POST['lignecontenu'];
    $titre = $_POST['titre'];
    $texte = $_POST['texte'];
    
    // On récupère l'image actuelle pour ne pas la perdre (même si on ne la change pas ici)
    $data = get_contenu_by_id($id);
    $image = $data['image'];

    // Mise à jour des textes
    if (modifier_contenu($id, $ligne, $titre, $texte, $image)) {
        $_SESSION['msg'] = "Mise à jour réussie.";
    }
}

header("Location: ../../section_apropos.php");
exit();
?>
