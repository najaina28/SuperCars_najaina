<?php
include 'connexion.php';

function ajouterMessageClient(
    $id_client,
    $message,
    $prenom = '',
    $nom = '',
    $email = '',
    $telephone = ''
) {
    global $bdd;  

    $result = [
        'success' => false,
        'message' => '',
        'id'      => null
    ];

    $message = trim($message);
    if (empty($message)) {
        $result['message'] = "Le message ne peut pas être vide.";
        return $result;
    }

    // Si pas de client (id_client <= 0), on met NULL dans la base
    $id_client_val = ($id_client > 0) ? (int)$id_client : null;

    $sql = "INSERT INTO message (id_client, message, nom, prenom, email, telephone, date_envoi) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($bdd, $sql);

    if (!$stmt) {
        $result['message'] = "Erreur préparation : " . mysqli_error($bdd);
        return $result;
    }

    mysqli_stmt_bind_param($stmt, "isssss", $id_client_val, $message, $nom, $prenom, $email, $telephone);

    if (mysqli_stmt_execute($stmt)) {
        $idNouveau = mysqli_insert_id($bdd);
        $result['success'] = true;
        $result['id']      = $idNouveau;
        $result['message'] = "Votre message a bien été envoyé !";
    } else {
        $result['message'] = "Erreur lors de l'envoi : " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    return $result;
}