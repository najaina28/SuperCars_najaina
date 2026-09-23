<?php 

include 'backend/gestion_service/fonctionService.php';

$service_liste = selectAllService($bdd);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des services - Admin Supercar</title>
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
            <h1><i class="bi bi-grid-3x3-gap"></i> Liste des services</h1>
            <p>Gérez l'ensemble des services proposés sur votre site Supercar.</p>
        </div>
        <a href="backend/gestion_service/ajout_service.php" class="btn-add">
            <i class="bi bi-plus-lg"></i> Nouveau service
        </a>
    </div>

    <!-- Barre de recherche -->
    <div class="toolbar">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Rechercher un service…" id="searchInput" oninput="filterTable()">
        </div>
        <span class="badge-count" id="countBadge">6 services</span>
    </div>

    <!-- Table -->
    <div class="table-card">
        <table id="serviceTable">
            <thead>
                <tr>
                    <th style="width:60px">Image</th>
                    <th>Nom / Titre</th>
                    <th class="titre-col">Description</th>
                    <th>Prix</th>
                    <th style="width:100px; text-align:center">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">

            <?php foreach($service_liste as $service) { ?> 

                <tr>
                    <td class = "photo">
                        <div class="img-placeholder"><img class="service-img" src =  " backend/gestion_service/uploads/<?php echo $service['image_service']; ?>"></div>
                    </td>
                    <td>
                        
                        <div class="service-name"><?php echo $service['nom_service']?></div>
                        <div class="service-titre"><?php echo $service['titre_service']?></div>
                    </td>
                    <td class="desc-cell titre-col"><?php echo $service['description_service']?></td>
                    <td><span class="prix-badge"><i class="bi bi-currency-euro"></i> <?php echo $service['prix_service']?></span></td>
                    <td>
                        <div class="actions" style="justify-content:center">
                            <a href="backend/gestion_service/edit_service.php?id=<?= $service['id_service'] ?>" class="btn-icon edit" title="Modifier"><i class="bi bi-pencil"></i></a>
                            <a href="backend/gestion_service/delete_service.php?id=<?= $service['id_service']?>" class="btn-icon delete" title="Supprimer" onclick="return confirm('Supprimer ce service ?')"><i class="bi bi-trash3"></i></a>
                        </div>
                    </td>
                </tr>

            <?php }?>

              

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-bar">
            <span class="pagination-info">Affichage de 1 – 6 sur 6 services</span>
            <div class="pagination-btns">
                <button class="pg-btn" disabled><i class="bi bi-chevron-left"></i></button>
                <button class="pg-btn active">1</button>
                <button class="pg-btn" disabled><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
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
            if (match) visible++;
        });

        document.getElementById('countBadge').textContent = visible + ' service' + (visible > 1 ? 's' : '');
    }
</script>

</body>
</html>