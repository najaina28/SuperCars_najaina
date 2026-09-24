<?php

include 'connexion.php';


/* fonction pour récupérer toutes les infos d'un client */
function getClient($id)
{

    global $bdd;

    if (empty($id))
        return false;

    $sql = "SELECT c.*, l.role FROM client c LEFT JOIN login l ON c.id_client = l.id_client WHERE c.id_client = $id";
    $result = mysqli_query($bdd, $sql);

    return mysqli_fetch_assoc($result);

}

/* fonction pour récupérer les initiales du client (première lettre du prénom + nom) */
function getInitiales($prenom, $nom)
{

    $premiere_lettre_prenom = substr($prenom, 0, 1);
    $premiere_lettre_nom = substr($nom, 0, 1);

    return strtoupper($premiere_lettre_prenom . $premiere_lettre_nom);

}

/* fonction pour compter le nombre de demandes d'essai d'un client */
function getNbDemandes($id_client)
{

    global $bdd;

    $sql = "SELECT COUNT(*) as nb FROM demande_essai WHERE id_client = $id_client";
    $result = mysqli_query($bdd, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['nb'];

}

/* fonction pour récupérer les demandes d'essai d'un client avec les détails voiture + marque + image */
function getDemandesEssai($id_client)
{

    global $bdd;

    $sql = "SELECT d.*, v.modele, v.idvoiture, m.nom_marque,
                    (SELECT CONCAT('assets/images/', url_image) FROM image WHERE idvoiture = v.idvoiture LIMIT 1) as main_image
                FROM demande_essai d
                JOIN voiture v ON d.idvoiture = v.idvoiture
                JOIN marques m ON v.id_marque = m.id_marque
                WHERE d.id_client = $id_client
                ORDER BY d.date_essai DESC";

    return mysqli_query($bdd, $sql);

}

/* fonction pour récupérer les images d'une voiture (pour les posts du profil) */
function getImagesVoiture($id_voiture)
{

    global $bdd;

    $sql = "SELECT url_image FROM image WHERE idvoiture = $id_voiture";
    $result = mysqli_query($bdd, $sql);
    $images = [];

    while ($img = mysqli_fetch_assoc($result)) {
        $images[] = 'assets/images/' . $img['url_image'];
    }

    return $images;

}

/* fonction pour formater le statut de la demande */
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

/* fonction pour formater la date en français */
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

/* fonction pour modifier les informations d'un client */
function modifierClient($id, $nom, $prenom, $mail, $telephone, $adresse)
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

?>