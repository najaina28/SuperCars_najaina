<?php

include 'connexion.php';

/* fonction pour récupérer un client par son email */
function getClientByEmail($email)
{
    global $bdd;
    $sql = "SELECT c.*, l.mot_de_passe, l.role FROM client c 
            JOIN login l ON c.id_client = l.id_client 
            WHERE c.mail = '$email'";
    $result = mysqli_query($bdd, $sql);
    return mysqli_fetch_assoc($result);
}

function getClientById($id)
{
    global $bdd;
    $sql = "SELECT c.*, l.role FROM client c
            LEFT JOIN login l ON c.id_client = l.id_client
            WHERE c.id_client = $id";
    $result = mysqli_query($bdd, $sql);
    return mysqli_fetch_assoc($result);
}


/* fonction pour vérifier le mot de passe avec password_verify */
function verifierMotDePasse($password, $hash)
{

    return password_verify($password, $hash);

}

?>
