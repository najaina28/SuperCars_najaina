<?php


function getAllMarques($bdd) {
    $marques_all = [];

    $sql = "SELECT 
                id_marque,
                nom_marque
            FROM marques";

    $requete_query = mysqli_query($bdd, $sql);

    while ($marque = mysqli_fetch_assoc($requete_query)) {
        $marques_all[] = $marque;
    }

    return $marques_all;
}


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
    (SELECT url_image FROM image i WHERE i.idvoiture = v.idvoiture ORDER BY i.priorite DESC, i.id_image ASC LIMIT 1) AS url_image
FROM voiture v";

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

function insertionVoiture(
    $conn,
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
    $id_marque,
    $disponibilite = 1
) {
    $sql = "INSERT INTO voiture (
                modele,
                prix,
                datesortie,
                kilometrage,
                boite_de_vitesse,
                carburant,
                puissance,
                couleur,
                provenance,
                details,
                id_marque,
                disponibilite
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
 
    $stmt = mysqli_prepare($conn, $sql);
 
    mysqli_stmt_bind_param(
        $stmt,
        "sdsississsii",
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
        $id_marque,
        $disponibilite
    );
 
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($conn);
    }
    return false;
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

    ///2. SUPPRIMER IMAGE PHYSIQUE S'IL Y A UN NOUVEAU FICHIER
    if ($old_image && !empty($url)) {
        $old_path = __DIR__ . "/../../../Site web/assets/images/" . $old_image['url_image'];
        if (file_exists($old_path) && !is_dir($old_path)) {
            unlink($old_path);
        }
    }

    /// 3. METTRE A JOUR LA BASE
    if (!empty($url)) {
        $sql_update = "UPDATE image SET url_image = ?, priorite = ? WHERE id_image = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "sii", $url, $priority, $id);
        return mysqli_stmt_execute($stmt_update);
    } else {
        $sql_update = "UPDATE image SET priorite = ? WHERE id_image = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "ii", $priority, $id);
        return mysqli_stmt_execute($stmt_update);
    }
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

function addImageVoiture($conn, $idvoiture, $url_image, $priorite = 0)
{
    return insertImage($conn, $url_image, $idvoiture, $priorite);
}

function deleteImage($conn, $id_image)
{
    $sql_old = "SELECT url_image FROM image WHERE id_image = ?";
    $stmt_old = mysqli_prepare($conn, $sql_old);
    mysqli_stmt_bind_param($stmt_old, "i", $id_image);
    mysqli_stmt_execute($stmt_old);
    $result_old = mysqli_stmt_get_result($stmt_old);
    $old_image = mysqli_fetch_assoc($result_old);

    if ($old_image) {
        $old_path = __DIR__ . "/../../../Site web/assets/images/" . $old_image['url_image'];
        if (file_exists($old_path) && !is_dir($old_path)) {
            unlink($old_path);
        }
    }

    $sql_delete = "DELETE FROM image WHERE id_image = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_image);
    return mysqli_stmt_execute($stmt_delete);
}

function deleteVoiture($conn, $id)
{
    $sql = "SELECT url_image FROM image WHERE idvoiture = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($img = mysqli_fetch_assoc($result)) {
        $path = __DIR__ . "/../../../Site web/assets/images/" . $img['url_image'];

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