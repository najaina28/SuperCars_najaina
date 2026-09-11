<?php



function fetchDemandesAttente($conn) {
    $ndea; //nombre demande en attente

    $sql = "SELECT COUNT(id_demande) as nbr FROM demande_essai WHERE statut = 'en_cours'";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $ndea = $row['nbr'];
        }

        mysqli_stmt_close($stmt);
    }

    return $ndea;
}

function fetchDemandesAujourdhui($conn,$date_essai) {
    $ndea; //nombre demande en attente

    $sql = "SELECT COUNT(id_demande) as nbr FROM demande_essai WHERE date_essai = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $date_essai);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $ndea = $row['nbr'];
        }

        mysqli_stmt_close($stmt);
    }

    return $ndea;
}

function fetchClientDemande($conn) {
    $nbr = 0;

    $sql = "SELECT COUNT(id_demande) as nbr FROM demande_essai GROUP BY id_client";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $nbr = $row['nbr'];
        }

        mysqli_stmt_close($stmt);
    }

    return $nbr;
}


function tauxDemandesEnAttente($conn,$allDemande,$allAttente) {

    if($allDemande != 0) {
        $prc = ($allAttente / $allDemande) * 100;
    } else {
        $prc = 0;
    }
    return $prc;

}

function Get4moisAvant($date){
    $moisAvant =  [];

    $tousmois = [
    1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
    5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
    9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
    ];

    $mois = date('n', strtotime($date));
    $i = $mois;
    $j = 0;
    while($j < 4){
        $moisAvant[$j] = [
            'id' => $i,
            'mois' => $tousmois[$i]
        ];
        $i--;
        $j++;

        if ($i == 0) {
            $i = 12;
        }
    }

    return $moisAvant;

}


function CountAllDemande($conn){
    $nbr = 0;

    $sql = "SELECT COUNT(id_demande) as nbr FROM demande_essai";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $nbr = $row['nbr'];
        }

        mysqli_stmt_close($stmt);
    }

    return $nbr;
}


function CountAllVoiture($conn){
    $nbr = 0;

    $sql = "SELECT COUNT(idvoiture) as nbr FROM voiture";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $nbr = $row['nbr'];
        }

        mysqli_stmt_close($stmt);
    }

    return $nbr;
}

function CountDemandeMois($conn,$mois){
    $nbr = 0;

    $sql = "SELECT COUNT(id_demande) as nbr FROM demande_essai WHERE MONTH(date_essai) = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $mois);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $nbr = $row['nbr'];
        }

        mysqli_stmt_close($stmt);
    }

    return $nbr;
}

function PourcentageCourbe($conn,$mois) {
    $nombreTotale =  CountAllDemande($conn);
    $nbrdemandeMois =  CountDemandeMois($conn,$mois);
    $pourcentageCouleurCourbe = 0;

    if ($nbrdemandeMois != 0) {
        $pourcentagemois = ($nbrdemandeMois * 100) /  $nombreTotale;
    } else {
        $pourcentagemois = 0;
    }

    if($pourcentagemois != 0) {
    $pourcentageCouleurCourbe = (200 * $pourcentagemois) / 100;
    } else {
        $pourcentageCouleurCourbe = 0;
    }

    return $pourcentageCouleurCourbe;
}


function GetVoiturePopulaire($conn){
    $Data = [];

    $sql = "SELECT nbr,modele FROM
    (SELECT COUNT(d.id_demande) as nbr,v.modele as modele FROM demande_essai d 
    LEFT JOIN voiture v ON d.idvoiture = v.idvoiture GROUP BY d.idvoiture) as stat ORDER BY nbr DESC Limit 3";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $Data[$i] = [
                "Nombre" => $row['nbr'],
                "Modele" => $row['modele']
            ];
            $i++;
        }

        mysqli_stmt_close($stmt);
    }

    return $Data;
}


function PourcentageCouleur($conn,$nbrDemande_voiture) {
    $nombreTotale =  CountAllVoiture($conn);
    $pourcentagevoiture = 0;

    if ($nbrDemande_voiture != 0) {
        $pourcentagevoiture = ($nbrDemande_voiture * 100) /  $nombreTotale;
    } else {
        $pourcentagevoiture = 0;
    }

    return $pourcentagevoiture;
}

function CountNouveauClientdemoi($conn,$date) {
    $nbr = 0;

    $sql = "SELECT COUNT(id_login) as nbr FROM login WHERE MONTH(date_inscription) = MONTH(?)
    AND YEAR(date_inscription) = YEAR(?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $date, $date);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $nbr = $row['nbr'];
        }

        mysqli_stmt_close($stmt);
    }

    return $nbr;   
}


function CounttoutClient($conn) {
    $nbr = 0;

    $sql = "SELECT COUNT(id_client) as nbr FROM client";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $nbr = $row['nbr'];
        }

        mysqli_stmt_close($stmt);
    }

    return $nbr;   
}

///Pour compter les nombre de demande d'essaie que les clients on fait dans un mois
function CountlesInscrisquifaitdemande($conn,$daty_de_consultation) {
    $nbrClientfaitdemande = 0;

    $sql = "SELECT COUNT(*) as totalinscriddemande FROM demande_essai WHERE YEAR(date_demande) = YEAR(?) GROUP BY id_client";

    $stmt = mysqli_prepare($conn,$sql);

    if($stmt) {
        
        mysqli_stmt_bind_param($stmt, "s", $daty_de_consultation);
        mysqli_stmt_execute($stmt);
        $parcourir = mysqli_stmt_get_result($stmt);

        if($ligne = mysqli_fetch_assoc($parcourir)) {
            $nbrClientfaitdemande = $ligne['totalinscriddemande'];
        }
    }

    return $nbrClientfaitdemande;

}

function PourcentageConvertionClientdemoi($conn,$date) 
{  
    $nbrclient = CounttoutClient($conn);
    $demandedesinscrit = CountlesInscrisquifaitdemande($conn,$date);
    $pourcentagearetourner = 0;

    if($demandedesinscrit == 0){

    } else {
        $pourcentagearetourner = ($demandedesinscrit * 100)/$nbrclient;
    }
    return $pourcentagearetourner;
}

?>