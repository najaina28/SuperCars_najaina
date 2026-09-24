<?php

function getAllMessage($bdd) {
    $tab_resultat = [];

    $requete_all_message = "SELECT nom,prenom,email,telephone,date_envoi,message FROM message";

    $state = mysqli_prepare($bdd,$requete_all_message);

    if($state) {
        mysqli_stmt_execute($state);
        $lesDonnees = mysqli_stmt_get_result($state);

        $i = 0;
        while($ligne = mysqli_fetch_assoc($lesDonnees)) {
            $tab_resultat[$i] = [
                "nom" => $ligne['nom'],
                "prenom" => $ligne['prenom'],
                "telephone" => $ligne['telephone'],
                "email" => $ligne['email'],
                "date_envoie" => $ligne['date_envoi'],
                "message" => $ligne['message']
            ];
            $i++;
        }

        return $tab_resultat;
    }
}

?>