<?php

include("backend/connexion.php");
include("backend/gestion_demande/FonctionDemande.php");

$Demande_essai = Get_All_Demande($bdd);
$Demande_essai_Date = filtrerDemandeDate($bdd,"2026-03-18");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supercar - Demandes d'essai</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/demande_essai.css">
    <link rel="stylesheet" href="assets/header.css">
</head>
<body>

    <?php  include("include/header.php");?>

    <main class="content">
        <header class="header-section">
            <h1>Demandes d'essai</h1>
            <div class="filter-group">
                <span>Filtrer :</span>
                <button class="btn-filter" data-type="date">Date</button>
                <button class="btn-filter" data-type="statut">Statut</button>
            </div>
        </header>

        
            <p id= "resultat"></p>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Modele</th>
                        <th>Date essai</th>
                        <th>Client</th>
                        <th>Statut</th>
                        <th>Modifier statut</th>
                    </tr>
                </thead>
        
        <tbody id="table-body">
        <?php foreach($Demande_essai as $essai) { ?>
        <tr>

            <td><?php echo $essai['id']; ?></td>
            <td><?php echo $essai['modele']; ?></td>
            <td><?php echo $essai['daty']; ?></td>
            <td><?php echo $essai['nom']; ?></td>
            <td><?php echo $essai['stat']; ?></td>

            <td>
                <form action="backend/gestion_demande/update_statut.php" method="post" class="form-inline">

                    <input type="hidden" name="id_demande" value="<?php echo $essai['id']; ?>">

                    <div class="action-group">
                        <select name="statut" class="select-statut">
                            <option value="valide">Valider</option>
                            <option value="annule">Annuler</option>
                            <option value="en_cours">En cours</option>
                        </select>

                        <button type="submit" class="btn-confirmer">
                            Confirmer
                        </button>
                    </div>

                </form>
            </td>

        </tr>
        <?php } ?>
        </tbody>
        
        </table>
        </div>

        <div class="footer-actions">
           
        </div>
    </main>

<script>
    
        document.querySelectorAll(".btn-filter").forEach(btn => {
    btn.addEventListener("click", () => {

        const valeur = btn.dataset.type;

        document.getElementById("resultat").innerText = "Chargement...";

        setTimeout(() => {
            fetch("backend/gestion_demande/traitement_Filtrage.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ type: valeur })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("resultat").innerText = data.message;

                if (data.html) {
                    document.getElementById("table-body").innerHTML = data.html;
                }
            })
            .catch(error => {
                document.getElementById("resultat").innerText = "Erreur";
            });

        }, 500);

    });
});

</script>

</body>

</html>