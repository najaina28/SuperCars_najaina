<?php 

session_start();
// Protection : réservé aux admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location: loginAdmin.php');
    exit();
}

include(__DIR__ . "/backend/connexion.php");
include(__DIR__ . "/backend/gestion_demande/FonctionDemande.php");
include(__DIR__ . "/backend/gestion_tableau_bord/FonctionTableauBord.php");


$demande_essai = count(Get_All_Demande($bdd));

$Demande_attent = fetchDemandesAttente($bdd);

$prc = tauxDemandesEnAttente($bdd,$demande_essai,$Demande_attent);

$Demande_Ajourdhui =  fetchDemandesAujourdhui($bdd,date("Y-m-d")); 

$ClientDemande = fetchClientDemande($bdd);

$MoisAvant = Get4moisAvant(date("Y-m-d"));

$voiturePopulaire = GetVoiturePopulaire($bdd);

$countNouveauCompte = CountNouveauClientdemoi($bdd,date("Y-m-d"));

$tauxdeconvertion = PourcentageConvertionClientdemoi($bdd,date("Y-m-d"));

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperCar - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href= "assets/tableau_bord.css">
</head>
<body>

<?php  include("include/header.php");?>

<main class="container-fluid p-4">

    <div class="page-header">
        <div class="page-header-left">
            <h1><i class="bi bi-speedometer2"></i> Tableau de bord</h1>
            <p>Consultez en un coup d’œil les principales informations et activités de votre site Supercar.</p>
        </div>
    </div>


    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="icon-box bg-white text-primary">
                        <i class="bi bi-clock-history fs-1"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-muted mb-0 small">Demandes en attente</p>
                    <h3 class="fw-bold"><?php echo $Demande_attent; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="icon-box bg-white text-primary">
                        <i class="bi bi-car-front-fill fs-1 text-primary"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-muted mb-0 small">Essais aujourd'hui</p>
                    <h3 class="fw-bold"><?php echo $Demande_Ajourdhui; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="icon-box bg-white text-primary">
                        <i class="bi bi-graph-up-arrow fs-1 text-success"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-muted mb-0 small">Taux de conversion de ce mois</p>
                    <h3 class="fw-bold"><?php echo $tauxdeconvertion; ?>%</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="icon-box bg-white text-primary">
                        <i class="bi bi-person-fill fs-1 text-primary"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-muted mb-0 small">Nouveaux clients de ce mois</p>
                    <h3 class="fw-bold"><?php echo $countNouveauCompte;?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm p-4 h-100">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <h5 class="fw-bold mb-4">Évolution des demandes d'essai</h5>
                    </div>

                    <div class="col-12 col-md-6">
                        <input class="form-control mb-4" type="date" id="date_arevoir" name = "date_arevoir" style = "border: 1px solid #dee2e6;border-radius: 8px;background-color: white;color: #000;font-size: 14px;">
                    </div>
                </div>

                <div class="d-flex align-items-end justify-content-around border-bottom" style="height: 250px;" id = "histogramme">

                <?php
                
                for($i = 3 ; $i >= 0 ; $i--) { 
                    
                    $hauteur = PourcentageCourbe($bdd,$MoisAvant[$i]['id']);
                ?>

                    <div class="text-center">
                        <div class="bar-custom" style="height: <?php echo $hauteur; ?>px;"></div>
                        <small class="text-muted"><?php echo $MoisAvant[$i]['mois']; ?></small>
                    </div>
                <?php }
                
                ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4">Véhicules populaires</h5>

                <?php foreach($voiturePopulaire as $voiture){ 
                    $couleur = PourcentageCouleur($bdd,$voiture['Nombre']);
                    ?>
                
                    <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="d-block fw-bold small"><?php echo $voiture['Modele']; ?></span>
                        </div>
                        <span class="fw-bold"><?php echo $voiture['Nombre']; ?></span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width: <?php echo $couleur;?>%"></div>
                    </div>
                    </div>

                <?php } ?>
                
            </div>
        </div>
    </div>
</main>
</body>

<script>
    document.getElementById("date_arevoir").addEventListener("change", function () {
        const dateEntree = this.value;

        fetch("backend/gestion_tableau_bord/TraitementDonneesCourbe.php", {
        method: "POST",
        headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "date_arevoir=" + encodeURIComponent(dateEntree)
        })
        .then(response => response.json())
        .then(data => {

            console.log(data);

            const resultat = document.getElementById("histogramme");

            resultat.innerHTML = "";

            data.forEach(element => {
                resultat.innerHTML += `

                    <div class="text-center">
                        <div class="bar-custom" style="height: ${element.hauteur}px;"></div>
                        <small class="text-muted">${element.mois}</small>
                    </div>
                `;
            });

        })
        .catch(error => {
        console.log("Erreur :", error);
        });


    });
</script>

</html>