<?php

include 'connexion.php';

/* fonction pour récupérer tous les détails d'une voiture (avec sa marque) */
function getFullVoiture($id)
{

    global $bdd;

    $sql = "SELECT v.*, m.nom_marque 
                FROM voiture v 
                JOIN marques m ON v.id_marque = m.id_marque 
                WHERE v.idvoiture = $id";
    $result = mysqli_query($bdd, $sql);

    return mysqli_fetch_assoc($result);

}

/* fonction pour récupérer les images sous forme de tableau simple */
function getImagesArray($id)
{

    global $bdd;

    $sql = "SELECT url_image FROM image WHERE idvoiture = $id";
    $result = mysqli_query($bdd, $sql);
    $images = [];

    while ($img = mysqli_fetch_assoc($result)) {
        $images[] = 'assets/images/' . $img['url_image'];
    }

    return $images;

}

/* fonction pour récupérer les voitures similaires avec leurs marques et images */
function getSimilairesData($id_marque, $id_actuelle)
{

    global $bdd;

    $sql = "SELECT v.*, m.nom_marque, (SELECT CONCAT('assets/images/', url_image) FROM image WHERE idvoiture = v.idvoiture LIMIT 1) as main_image
                FROM voiture v 
                JOIN marques m ON v.id_marque = m.id_marque 
                WHERE v.id_marque = $id_marque AND v.idvoiture != $id_actuelle 
                LIMIT 3";

    return mysqli_query($bdd, $sql);

}

/* fonction pour formater le prix */
function formatPrix($prix)
{

    return number_format($prix, 0, ',', ' ') . ' RS';

}

/* fonction pour formater le kilométrage */
function formatKm($km)
{

    return number_format($km, 0, ',', ' ') . ' km';

}

/* fonction pour extraire l'année d'une date */
function formatAnnee($date)
{

    return date('Y', strtotime($date));

}

/* fonction pour formater la disponibilité */
function formatDispo($dispo)
{

    return $dispo ? 'Disponible' : 'Indisponible';

}

/*
    dans fonctionsDetails.php
*/

function getAllVoiture() {
    global $bdd;
    $sql = "SELECT idvoiture, modele FROM voiture ORDER BY modele ASC";
    return mysqli_query($bdd, $sql);
}

