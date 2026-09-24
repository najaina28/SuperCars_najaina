<?php

include(__DIR__ . "/FonctionTableauBord.php");
include(__DIR__ . "/../connexion.php");

if (isset($_POST["date_arevoir"])) {

    $data = [];

    $dateArevoir = $_POST["date_arevoir"];
    $les4moisavant = Get4moisAvant($dateArevoir);

    for ($i = 3; $i >= 0; $i--) {

        $hauteur = PourcentageCourbe(
            $bdd,
            $les4moisavant[$i]['id']
        );

        $data[] = [
            "mois" => $les4moisavant[$i]['mois'],
            "hauteur" => $hauteur
        ];
    }

    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($data);
}