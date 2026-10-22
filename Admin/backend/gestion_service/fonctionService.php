<?php  
if (file_exists('backend/connexion.php')) include 'backend/connexion.php';
else if (file_exists('../connexion.php')) include '../connexion.php';


function selectAllService($conn) {
    $service_all = [];

    $sql = "SELECT * FROM service";

    $requete_query = mysqli_query($conn,$sql);

    while($service = mysqli_fetch_assoc($requete_query)){
        $service_all []= $service;
    }
    return $service_all;
}


function insertionService($nom, $titre, $description, $prix, $image)
{
    global $bdd;

    $sql = "INSERT INTO service 
            (nom_service, titre_service, description_service, prix_service, image_service)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $bdd->prepare($sql);

    $stmt->bind_param("sssds", $nom, $titre, $description, $prix, $image);

    $stmt->execute();
}

function updateService($id, $nom, $titre, $description, $prix, $image = null)
{
    global $bdd;

    if ($image === null) {
        
        $sql = "UPDATE service SET
                nom_service = ?,
                titre_service = ?,
                description_service = ?,
                prix_service = ?
                WHERE id_service = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->bind_param("sssdi", $nom, $titre, $description, $prix, $id);

    } else {
        
        $sql = "UPDATE service SET
                nom_service = ?,
                titre_service = ?,
                description_service = ?,
                prix_service = ?,
                image_service = ?
                WHERE id_service = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->bind_param("sssdsi", $nom, $titre, $description, $prix, $image, $id);
    }

    return $stmt->execute();
}


function deleteService($id) {

    global $bdd;

    $sql = "SELECT image_service FROM service WHERE id_service = ?";

    $stmt = $bdd->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $service = $result->fetch_assoc();

    if($service) {
        if(!empty($service['image_service'])){
            $imagePath = __DIR__ . "/../../../images/service/" . $service['image_service'];
            if(file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
    $stmt = $bdd->prepare("DELETE FROM service WHERE id_service =?");
    $stmt->bind_param("i", $id);
    return $stmt->execute(); 
    }
    return false;
}



?>