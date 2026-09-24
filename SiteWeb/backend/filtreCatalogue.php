<?php
include("connexion.php");
include("fonctionCatalogue.php");

$selected_id = 0;
if (isset($_GET['marque_id'])) {
    $selected_id = intval($_GET['marque_id']);
}

$recherche = "";
if (isset($_GET['indice'])) {
    $recherche = trim($_GET['indice']);
}

$tab_voitures = [];

if ($selected_id == 0 && $recherche == "") {
    $tab_voitures = get_all_voiture($bdd);
}
if ($recherche != "") {
    $tab_voitures = get_voiture_by_indice($bdd, $recherche);
}
if ($selected_id != 0) {
    $tab_voitures = get_voiture_by_marque($bdd, $selected_id);
}

if (empty($tab_voitures)) {
    echo '<div class="col-12 text-center py-5">
            <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
            <h3 class="mt-3">Aucun véhicule trouvé</h3>
            <p class="text-muted">Essayez d\'ajuster vos critères de recherche.</p>
          </div>';
} else {
    foreach ($tab_voitures as $voiture) { ?> 
    <div class="col-md-4">
        <div class="car-card">
            <img src="<?php echo $voiture['url_img']; ?>" alt="<?php echo $voiture['nom_marque'] . ' ' . $voiture['modele']; ?>">
            <div class="p-3">
                <h4><?php echo $voiture['modele']; ?></h4>
                <div class="car-specs">
                    <span><i class="bi bi-calendar"></i> <?php echo formatAnnee($voiture['datesortie']); ?> </span>
                    <span><i class="bi bi-speedometer2"></i> <?php echo formatKm($voiture['kilometrage']); ?> </span>
                    <span><i class="bi bi-fuel-pump"></i> <?php echo $voiture['carburant']; ?> </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="price"> <?php echo formatPrix($voiture['prix']); ?> </span>
                    <a href="details.php?id=<?php echo $voiture['idvoiture']; ?>" class="btn btn-orange-outline">Voir détails</a>
                </div>
            </div>
        </div>
    </div>
    <?php }
}
?>
