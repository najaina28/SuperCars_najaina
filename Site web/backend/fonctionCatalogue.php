<?php

    function get_all_voiture($conn){

        $voiture_all = [];

        $requete_all = "SELECT 
                v.idvoiture,
                v.modele,
                v.prix,
                v.datesortie,
                v.kilometrage,
                v.carburant,
                m.nom_marque,
                (SELECT CONCAT('assets/images/', url_image) 
                FROM image i 
                WHERE i.idvoiture = v.idvoiture AND i.priorite = 1
                LIMIT 1) AS url_img
                FROM voiture v 
                JOIN marques m ON v.id_marque = m.id_marque";

        $query_all = mysqli_query($conn,$requete_all);

        while($voiture_base = mysqli_fetch_assoc($query_all)){
                $voiture_all [] = $voiture_base;
        }

        return $voiture_all;
    }

    function get_voiture_by_marque($conn,$marque){

        $voiture_all = [];

        $requete_all = "SELECT 
                v.idvoiture,
                v.modele,
                v.prix,
                v.datesortie,
                v.kilometrage,
                v.carburant,
                m.nom_marque,
                (SELECT CONCAT('assets/images/', url_image) 
                FROM image i 
                WHERE i.idvoiture = v.idvoiture AND i.priorite = 1
                LIMIT 1) AS url_img
                FROM voiture v 
                JOIN marques m ON v.id_marque = m.id_marque 
                WHERE v.id_marque = $marque";

        $query_all = mysqli_query($conn,$requete_all);

        while($voiture_base = mysqli_fetch_assoc($query_all)){
                $voiture_all [] = $voiture_base;
        }

        return $voiture_all;
    }

    function get_all_marque($conn){

        $marque_all = [];

        $requete_all = "SELECT * FROM marques";

        $query_all = mysqli_query($conn,$requete_all);

        while($marque_base = mysqli_fetch_assoc($query_all)){
                $marque_all [] = $marque_base;
        }

        return $marque_all;
    }

    function get_all_modele($conn) {
        $modeles = [];
    
        $requete = "SELECT modele FROM voiture";
        $query = mysqli_query($conn, $requete);
    
        while($row = mysqli_fetch_assoc($query)) {
            $modeles[] = $row['modele']; // juste la valeur
        }
    
        return $modeles;
        }

    function get_voiture_by_indice($conn,$indice){

        $voiture_all = [];

        $requete = "SELECT v.idvoiture,
                   v.modele,
                   v.prix,
                   v.datesortie,
                   v.kilometrage,
                   v.carburant,
                   m.nom_marque,
                   (SELECT CONCAT('assets/images/', i.url_image)
                    FROM image i
                    WHERE i.idvoiture = v.idvoiture AND i.priorite = 1
                    LIMIT 1) AS url_img
            FROM voiture v
            JOIN marques m ON v.id_marque = m.id_marque
            WHERE v.modele LIKE '%$indice%' OR m.nom_marque LIKE '%$indice%'";

        $requete_query = mysqli_query($conn,$requete);

        while($voiture = mysqli_fetch_assoc($requete_query)) {

                $voiture_all[] = $voiture;

        }
        return $voiture_all;
    }

    /* fonction pour formater le prix */
    function formatPrix($prix)
    {
        return number_format($prix, 0, ',', ' ') . ' RS';
    }

    /* fonction pour formater le kilométrage */
    function formatKm($km)
    {
        return number_format($km, 0, ',', ' ') . ' km';
    }

    /* fonction pour extraire l'année d'une date */
    function formatAnnee($date)
    {
        return date('Y', strtotime($date));
    }

?>