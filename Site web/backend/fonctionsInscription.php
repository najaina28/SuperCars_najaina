<?php

include 'connexion.php';

/* fonction pour vérifier si un email existe déjà */
function emailExiste($email)
{

    global $bdd;

    $sql = "SELECT * FROM client WHERE mail = '$email'";
    $result = mysqli_query($bdd, $sql);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

}

/* fonction pour inscrire un nouveau client avec password_hash */
function inscrireClient($nom, $prenom, $email, $telephone, $password)
{

    global $bdd;

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO client (nom, prenom, mail, telephone) 
                VALUES ('$nom', '$prenom', '$email', '$telephone')";

    if (mysqli_query($bdd, $sql)) {
        $id_client = mysqli_insert_id($bdd);
        $sql_login = "INSERT INTO login (id_client, mot_de_passe, role) VALUES ($id_client, '$hash', 'user')";
        return mysqli_query($bdd, $sql_login);
    }
    
    return false;

}

?>
