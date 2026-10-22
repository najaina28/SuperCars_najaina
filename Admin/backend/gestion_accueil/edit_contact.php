<?php
session_start();
include 'FonctionContenu.php';

if (isset($_POST['id_contenu'])) {
    $id    = $_POST['id_contenu'];
    $ligne = $_POST['lignecontenu'];
    $titre = $_POST['titre'];
    $texte = $_POST['texte'];
    
    // Récupérer l'image actuelle si elle existe
    $data = get_contenu_by_id($id);
    $image = $data['image'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $target_dir = __DIR__ . "/../../../images/background/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    }

    if (modifier_contenu($id, $ligne, $titre, $texte, $image)) {
        $_SESSION['msg'] = "Informations de contact mises à jour avec succès.";
    } else {
        $_SESSION['msg'] = "Erreur lors de la modification.";
    }
}

header("Location: ../../section_contact.php");
exit();
?>
