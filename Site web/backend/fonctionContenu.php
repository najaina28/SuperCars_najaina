<?php
require_once 'connexion.php';

// Récupère tout le contenu d'une page
function get_all_contenu_by_page($conn, $page) {
    $sql = "SELECT * FROM contenu WHERE page = '$page' ORDER BY lignecontenu ASC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Trouve une ligne spécifique par son numéro
function find_contenu($contents, $line) {
    foreach ($contents as $item) {
        if ($item['lignecontenu'] == $line) return $item;
    }
    return null;
}
?>
