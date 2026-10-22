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

function formatStatut($statut)
{

    switch ($statut) {
        case 'en_cours':
            return '<span class="badge bg-primary text-white rounded-pill px-3 py-2"><i class="bi bi-hourglass-split me-1"></i> En cours de traitement</span>';
        case 'valide':
            return '<span class="badge bg-success text-white rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Validée</span>';
        case 'annule':
            return '<span class="badge bg-danger text-white rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i> Annulée</span>';
        default:
            return '<span class="badge bg-secondary text-white rounded-pill px-3 py-2">Inconnu</span>';
    }

}


function modifierClient($conn ,$id, $nom, $prenom, $mail, $telephone, $adresse)
{

    global $bdd;

    $sql = "UPDATE client SET 
                nom = '$nom', 
                prenom = '$prenom', 
                mail = '$mail', 
                telephone = '$telephone', 
                adresse = '$adresse' 
            WHERE id_client = $id";

    return mysqli_query($bdd, $sql);

}

function formatDateFr($date)
{

    $mois = [
        1 => 'janvier',
        2 => 'février',
        3 => 'mars',
        4 => 'avril',
        5 => 'mai',
        6 => 'juin',
        7 => 'juillet',
        8 => 'août',
        9 => 'septembre',
        10 => 'octobre',
        11 => 'novembre',
        12 => 'décembre'
    ];

    $timestamp = strtotime($date);
    $jour = date('j', $timestamp);
    $numMois = (int) date('n', $timestamp);
    $annee = date('Y', $timestamp);

    return $jour . ' ' . $mois[$numMois] . ' ' . $annee;

}

?>