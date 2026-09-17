<?php


function get_all_info($conn, $id) {
    // On utilise LEFT JOIN pour ne pas perdre l'utilisateur s'il n'a pas encore fait de demande
    $requete = "SELECT 
                    c.id_client, c.nom, c.prenom, c.mail, c.telephone, c.adresse,
                    COUNT(d.id_demande) as nombre 
                FROM client c 
                LEFT JOIN demande_essai d ON c.id_client = d.id_client 
                WHERE c.id_client = $id
                GROUP BY c.id_client";

    $execution = mysqli_query($conn, $requete);
    return mysqli_fetch_assoc($execution);
}

function get_all_demande($conn, $id) {
    $table_demande = [];
    $requete = "SELECT v.modele as modele, d.idvoiture as id, d.date_essai as daty, d.statut as stat 
                FROM demande_essai d 
                JOIN voiture v ON d.idvoiture = v.idvoiture  
                WHERE d.id_client = $id";

    $execution = mysqli_query($conn, $requete);
    while($recuperation = mysqli_fetch_assoc($execution)){
        $table_demande[] = $recuperation;
    }
    return $table_demande;
}

function get_photo_id($conn, $id_voiture) {
    $tab_photo = [];
    $requete = "SELECT url_image, priorite FROM image WHERE idvoiture = $id_voiture";
    $execute = mysqli_query($conn, $requete);
    while($get = mysqli_fetch_assoc($execute)) {
        $tab_photo[] = $get;
    }
    return $tab_photo;
}


?>