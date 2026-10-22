<?php 

session_start();
// Protection : réservé aux admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location: loginAdmin.php');
    exit();
}

include 'backend/gestion_detail/fonctionDetail.php';
include 'backend/connexion.php';

$Voiture = selectAllVoiture($bdd);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des voitures - Admin Supercar</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/index.css">
    <link rel="stylesheet" href="assets/service2.css">
</head>
<body>

<?php include('include/header.php'); ?>

<div id="main-content">

    <!-- En-tête -->
    <div class="page-header">
        <div class="page-header-left">
            <h1><i class="bi bi-car-front"></i> Liste des voitures</h1>
            <p>Gérez les voitures disponibles sur votre site Supercar.</p>
        </div>

        <a href="backend/gestion_voiture/ajout_voiture.php" class="btn-add">
            <i class="bi bi-plus-lg"></i> Nouvelle voiture
        </a>
    </div>

    <!-- Barre de recherche -->
    <div class="toolbar">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Rechercher une voiture…" id="searchInput" oninput="filterTable()">
        </div>

        <span class="badge-count" id="countBadge">
            <?= count($Voiture) ?> voitures
        </span>
    </div>

    <!-- Table -->
    <div class="table-card">

        <table id="serviceTable">

            <thead>
                <tr>
                    <th style="width:90px">Image</th>
                    <th>Modèle</th>
                    <th>Prix</th>
                    <th>Kilométrage</th>
                    <th>Carburant</th>
                    <th>Boîte</th>
                    <th>Disponibilité</th>
                    <th style="width:100px; text-align:center">Actions</th>
                </tr>
            </thead>

            <tbody id="tableBody">

            <?php foreach($Voiture as $voiture) { ?> 

                <tr>

                    <!-- IMAGE -->
                    <td>
                        <?php if(!empty($voiture['url_image'])) { ?>

                            <img 
                                src="../images/voiture/<?= $voiture['url_image'] ?>" 
                                alt="voiture"
                                style="
                                    width:70px;
                                    height:50px;
                                    object-fit:cover;
                                    border-radius:8px;
                                "
                            >

                        <?php } else { ?>

                            <div class="img-placeholder">
                                <i class="bi bi-car-front"></i>
                            </div>

                        <?php } ?>
                    </td>

                    <!-- MODELE -->
                    <td>
                        <div class="service-name">
                            <?= $voiture['modele'] ?>
                        </div>

                        <div class="service-titre">
                            <?= $voiture['couleur'] ?>
                        </div>
                    </td>

                    <!-- PRIX -->
                    <td>
                        <span class="prix-badge">
                            <?= number_format($voiture['prix'], 2, ',', ' ') ?> €
                        </span>
                    </td>

                    <!-- KILOMETRAGE -->
                    <td>
                        <?= number_format($voiture['kilometrage'], 0, ',', ' ') ?> km
                    </td>

                    <!-- CARBURANT -->
                    <td>
                        <?= $voiture['carburant'] ?>
                    </td>

                    <!-- BOITE -->
                    <td>
                        <?= $voiture['boite_de_vitesse'] ?>
                    </td>

                    <!-- DISPONIBILITE -->
                    <td>

                        <?php if($voiture['disponibilite']) { ?>

                            <span style="color:green;font-weight:bold;">
                                Disponible
                            </span>

                        <?php } else { ?>

                            <span style="color:red;font-weight:bold;">
                                Indisponible
                            </span>

                        <?php } ?>

                    </td>

                    <!-- ACTIONS -->
                    <td>
                        <div class="actions" style="justify-content:center">

                            <a 
                                href="backend/gestion_detail/edit_voiture.php?id=<?= $voiture['idvoiture'] ?>" 
                                class="btn-icon edit"
                                title="Modifier"
                            >
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a 
                                href="backend/gestion_detail/delete_voiture.php?id=<?= $voiture['idvoiture'] ?>" 
                                class="btn-icon delete"
                                title="Supprimer"
                                onclick="return confirm('Supprimer cette voiture ?')"
                            >
                                <i class="bi bi-trash3"></i>
                            </a>

                        </div>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<?php include('include/footer.php'); ?>

<script>

function filterTable() {

    const query = document.getElementById('searchInput').value.toLowerCase();

    const rows = document.querySelectorAll('#tableBody tr');

    let visible = 0;

    rows.forEach(row => {

        const text = row.innerText.toLowerCase();

        const match = text.includes(query);

        row.style.display = match ? '' : 'none';

        if(match) visible++;

    });

    document.getElementById('countBadge').textContent =
        visible + ' voiture' + (visible > 1 ? 's' : '');
}

</script>

</body>
</html>