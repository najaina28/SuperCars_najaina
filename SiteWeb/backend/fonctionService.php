<?php

    function get_all_service($conn){

        $service_all = [];

        $requete_all_service = "SELECT nom_service,titre_service,description_service,image_service FROM service";

        $execution = mysqli_query($conn,$requete_all_service);

        while($get = mysqli_fetch_assoc($execution)){
            $service_all[] = $get;
        }

        return $service_all;

    }

?>