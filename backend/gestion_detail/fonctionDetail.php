<?php


function selectAllVoiture($conn) {
    $voiture_all = [];

    $sql = "SELECT 
    v.idvoiture,
    v.modele,
    v.prix,
    v.datesortie,
    v.kilometrage,
    v.disponibilite,
    v.boite_de_vitesse,
    v.carburant,
    v.puissance,
    v.couleur,
    v.provenance,
    v.details,
    i.url_image
FROM voiture v
LEFT JOIN image i 
    ON v.idvoiture = i.idvoiture 
    AND i.priorite = 1 GROUP BY v.idvoiture";

    $requete_query = mysqli_query($conn,$sql);

    while($voiture = mysqli_fetch_assoc($requete_query)){
        $voiture_all []= $voiture;
    }
    return $voiture_all;
}

function selectAllVoitureAllImage($conn, $id) {

    $voiture_all = [];

    $sql = "
        SELECT *
        FROM voiture
        LEFT JOIN image 
        ON voiture.idvoiture = image.idvoiture
        WHERE voiture.idvoiture = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result)) {

        $idvoiture = $row['idvoiture'];

        if (!isset($voiture_all[$idvoiture])) {

            $voiture_all[$idvoiture] = [
                'idvoiture' => $row['idvoiture'],
                'modele' => $row['modele'],
                'prix' => $row['prix'],
                'datesortie' => $row['datesortie'],
                'kilometrage' => $row['kilometrage'],
                'disponibilite' => $row['disponibilite'],
                'boite_de_vitesse' => $row['boite_de_vitesse'],
                'carburant' => $row['carburant'],
                'puissance' => $row['puissance'],
                'couleur' => $row['couleur'],
                'provenance' => $row['provenance'],
                'details' => $row['details'],
                'id_marque' => $row['id_marque'],
                'images' => []
            ];
        }

        if (!empty($row['url_image'])) {

            $voiture_all[$idvoiture]['images'][] = [
                'id_image' => $row['id_image'],
                'url_image' => $row['url_image'],
                'priorite' => $row['priorite']
            ];
        }
    }

    return $voiture_all;
}

function updateVoiture(
    $conn,
    $id,
    $modele,
    $prix,
    $datesortie,
    $kilometrage,
    $boite_de_vitesse,
    $carburant,
    $puissance,
    $couleur,
    $provenance,
    $details) {

    $sql = "UPDATE voiture SET
                modele = ?,
                prix = ?,
                datesortie = ?,
                kilometrage = ?,
                boite_de_vitesse = ?,
                carburant = ?,
                puissance = ?,
                couleur = ?,
                provenance = ?,
                details = ?
            WHERE idvoiture = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sdsississsi",
        $modele,
        $prix,
        $datesortie,
        $kilometrage,
        $boite_de_vitesse,
        $carburant,
        $puissance,
        $couleur,
        $provenance,
        $details,
        $id
    );

    return mysqli_stmt_execute($stmt);
}

function UpdateImage($conn, $id, $url, $idvoiture, $priority)
{
    /// 1. RECUPERER ANCIENNE IMAGE
    $sql_old = "SELECT url_image 
                FROM image 
                WHERE id_image = ?";

    $stmt_old = mysqli_prepare($conn, $sql_old);

    mysqli_stmt_bind_param($stmt_old, "i", $id);

    mysqli_stmt_execute($stmt_old);

    $result_old = mysqli_stmt_get_result($stmt_old);

    $old_image = mysqli_fetch_assoc($result_old);

    ///2. SUPPRIMER IMAGE PHYSIQUE
    if ($old_image) {

        $old_path = __DIR__ . "/uploads/" . $old_image['url_image'];

        if (file_exists($old_path)) {
            unlink($old_path);
        }
    }

    /// 3. SUPPRIMER DANS BASE

    $sql_delete = "DELETE FROM image WHERE id_image = ?";

    $stmt_delete = mysqli_prepare($conn, $sql_delete);

    mysqli_stmt_bind_param($stmt_delete, "i", $id);

    mysqli_stmt_execute($stmt_delete);

    //AJOUTER NOUVELLE IMAGE
    $sql_insert = "INSERT INTO image (
                        url_image,
                        idvoiture,
                        priorite
                    )
                    VALUES (?, ?, ?)";

    $stmt_insert = mysqli_prepare($conn, $sql_insert);

    mysqli_stmt_bind_param(
        $stmt_insert,
        "sii",
        $url,
        $idvoiture,
        $priority
    );

    return mysqli_stmt_execute($stmt_insert);
}

function insertImage($conn, $url_image, $idvoiture, $priorite)
{
    $sql = "INSERT INTO image (
                url_image,
                idvoiture,
                priorite
            )
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sii",
        $url_image,
        $idvoiture,
        $priorite
    );

    return mysqli_stmt_execute($stmt);
}

function deleteVoiture($conn, $id)
{
    
    $sql = "SELECT url_image FROM image WHERE idvoiture = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($img = mysqli_fetch_assoc($result)) {

        $path = __DIR__ . "/uploads/" . $img['url_image'];

        if (file_exists($path) && !is_dir($path)) {
            unlink($path);
        }
    }

    $sql_delete = "DELETE FROM voiture WHERE idvoiture = ?";

    $stmt_delete = mysqli_prepare($conn, $sql_delete);

    mysqli_stmt_bind_param($stmt_delete, "i", $id);

    return mysqli_stmt_execute($stmt_delete);
}

?>