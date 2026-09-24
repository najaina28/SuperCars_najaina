<?php
// Inclusion de la connexion (selon le dossier d'appel)
if (file_exists('backend/connexion.php')) include 'backend/connexion.php';
else if (file_exists('../connexion.php')) include '../connexion.php';

// Récupérer le contenu d'une page
function get_contenu_by_page($page) {
    global $bdd;
    $sql = "SELECT * FROM contenu WHERE page = '$page' ORDER BY lignecontenu ASC";
    $resultat = mysqli_query($bdd, $sql);
    return mysqli_fetch_all($resultat, MYSQLI_ASSOC);
}

// Récupérer une ligne par ID
function get_contenu_by_id($id) {
    global $bdd;
    $sql = "SELECT * FROM contenu WHERE id_contenu = $id";
    $resultat = mysqli_query($bdd, $sql);
    return mysqli_fetch_assoc($resultat);
}

// Ajouter du contenu
function ajouter_contenu($ligne, $titre, $texte, $image, $page) {
    global $bdd;
    $titre = str_replace("'", "''", $titre);
    $texte = str_replace("'", "''", $texte);
    $sql = "INSERT INTO contenu (lignecontenu, titre, texte, image, page) VALUES ($ligne, '$titre', '$texte', '$image', '$page')";
    return mysqli_query($bdd, $sql);
}

// Modifier du contenu
function modifier_contenu($id, $ligne, $titre, $texte, $image) {
    global $bdd;
    $titre = str_replace("'", "''", $titre);
    $texte = str_replace("'", "''", $texte);
    $sql = "UPDATE contenu SET lignecontenu = $ligne, titre = '$titre', texte = '$texte', image = '$image' WHERE id_contenu = $id";
    return mysqli_query($bdd, $sql);
}

// Supprimer du contenu
function supprimer_contenu($id) {
    global $bdd;
    return mysqli_query($bdd, "DELETE FROM contenu WHERE id_contenu = $id");
}
?>
