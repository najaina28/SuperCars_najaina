<?php

function Get_All_Demande($conn){
    $all_demande = [];

    $sql = "SELECT D.id_demande as id, C.nom as nom, V.modele as modele, D.statut as stat, D.date_essai as daty
            FROM demande_essai D 
            JOIN client C ON D.id_client = C.id_client 
            JOIN voiture V ON V.idvoiture = D.idvoiture";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $all_demande[] = $row;
        }

        mysqli_stmt_close($stmt);
    }

    return $all_demande;
}


function updateStatutDemande($bdd, $id, $statut) {

    $sql = "UPDATE demande_essai SET statut = ? WHERE id_demande = ?";

    $stmt = mysqli_prepare($bdd, $sql);

    if (!$stmt) {
        die("Erreur préparation : " . mysqli_error($bdd));
    }

    // s = string, i = integer
    mysqli_stmt_bind_param($stmt, "si", $statut, $id);

    if (!mysqli_stmt_execute($stmt)) {
        die("Erreur exécution : " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);

    return true;
}

function filtrerDemandeDate($conn) {

    $all_demande = [];

    $sql = "SELECT D.id_demande as id, C.nom as nom, V.modele as modele, D.statut as stat, D.date_essai as daty
            FROM demande_essai D 
            JOIN client C ON D.id_client = C.id_client 
            JOIN voiture V ON V.idvoiture = D.idvoiture ORDER BY D.date_essai DESC";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $all_demande[] = $row;
        }

        mysqli_stmt_close($stmt);
    }

    return $all_demande;

}

function filtrerDemandeStatut($conn) {

    $all_demande = [];

    $sql = "SELECT D.id_demande as id, C.nom as nom, V.modele as modele, D.statut as stat, D.date_essai as daty
            FROM demande_essai D 
            JOIN client C ON D.id_client = C.id_client 
            JOIN voiture V ON V.idvoiture = D.idvoiture ORDER BY D.statut ASC";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $all_demande[] = $row;
        }

        mysqli_stmt_close($stmt);
    }

    return $all_demande;

}

?>