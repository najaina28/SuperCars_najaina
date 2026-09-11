<?php

if (file_exists('backend/connexion.php')) include 'backend/connexion.php';
else if (file_exists('../connexion.php')) include '../connexion.php';
include("FonctionDemande.php");

$data = json_decode(file_get_contents("php://input"), true);

$type = $data["type"]?? "";
$html = "";

if($type == "date"){

    $result = filtrerDemandeDate($bdd);

    foreach ($result as $row) {
        $html .=  "<tr>
        <td>{$row['id']}</td>
        <td>{$row['modele']}</td>
        <td>{$row['daty']}</td>
        <td>{$row['nom']}</td>
        <td>{$row['stat']}</td>

        <td>
            <form action='backend/gestion_demande/update_statut.php' method='post' class='form-inline'>
                <input type='hidden' name='id_demande' value='{$row['id']}'>

                <div class='action-group'>
                    <select name='statut' class='select-statut'>
                        <option value='valide'>Valider</option>
                        <option value='annuler'>Annuler</option>
                        <option value='en_cours'>En cours</option>
                    </select>

                    <button type='submit' class='btn-confirmer'>
                        Confirmer
                    </button>
                </div>
            </form>
        </td>
    </tr>";
    }

    echo json_encode([
        "message" => "",
        "html" => $html
    ]);

}  elseif ($type == "statut"){

    $result = filtrerDemandeStatut($bdd);

    foreach ($result as $row) {
        $html .=  "<tr>
        <td>{$row['id']}</td>
        <td>{$row['modele']}</td>
        <td>{$row['daty']}</td>
        <td>{$row['nom']}</td>
        <td>{$row['stat']}</td>

        <td>
            <form action='backend/gestion_demande/update_statut.php' method='post' class='form-inline'>
                <input type='hidden' name='id_demande' value='{$row['id']}'>

                <div class='action-group'>
                    <select name='statut' class='select-statut'>
                        <option value='valide'>Valider</option>
                        <option value='annuler'>Annuler</option>
                        <option value='en_cours'>En cours</option>
                    </select>

                    <button type='submit' class='btn-confirmer'>
                        Confirmer
                    </button>
                </div>
            </form>
        </td>
    </tr>";
    }

    echo json_encode([
        "message" => "",
        "html" => $html
    ]);
}

?>