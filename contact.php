<?php

session_start();
// Protection : réservé aux admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location: loginAdmin.php');
    exit();
}

include(__DIR__ . "/backend/connexion.php");
include(__DIR__ . "/backend/gestion_contact/fonction_contact.php");

$data = getAllMessage($bdd);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/contact.css">
</head>
<body>
    <?php  include("include/header.php");?>
    <main>
        <div class="page-header">
        <div class="page-header-left">
            <h1><i class="bi bi-envelope"></i> Liste des messages</h1>
            <p>Gérez facilement les messages reçus par les visiteurs de votre site Supercar.</p>
        </div>
        </div>
        <div class = "liste-message">
            <?php
                for ($i = 0; $i < count($data); $i++) { ?>
                    <div class="message">
                        <div class="tete">
                            <div class="identite">
                                <strong>
                                    <?php echo $data[$i]["prenom"]; ?>
                                    <?php echo $data[$i]["nom"]; ?>
                                </strong>
                            </div>

                            <div class="coordonnees">
                                <span>Email : <?php echo $data[$i]["email"]; ?></span>
                                <span>Contact : <?php echo $data[$i]["telephone"]; ?></span>                            </div>
                        </div>

                        <div class="contenue">
                            <p class="message-contenue"><?= htmlspecialchars($data[$i]["message"]) ?></p>

                            <button type="button" class="voir-plus">
                                Voir plus
                            </button>
                            <button type="button" class="voir-moins">
                                Voir moins
                            </button> 

                            <span class = "date-heure"><?php echo date("d/m/Y à H:i", strtotime($data[$i]["date_envoie"])); ?></span>

                            
                        </div>

                    </div>

                <?php }
            ?>
        </div>
    </main>
</body>

<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".contenue").forEach(function (contenu) {

        const message = contenu.querySelector(".message-contenue");
        const button_plus = contenu.querySelector(".voir-plus");
        const button_moin = contenu.querySelector(".voir-moins");

        const texteComplet = message.textContent.trim();

        if (texteComplet.length > 40) {

            const texteCourt = texteComplet.substring(0, 40) + "...";

            message.textContent = texteCourt;

            button_plus.style.display = "inline";

            button_plus.addEventListener("click", function () {

                message.textContent = texteComplet;

                button_plus.style.display = "none";
                button_moin.style.display = "block";
            });

            button_moin.addEventListener("click", function () {

                message.textContent = texteCourt;

                button_plus.style.display = "block";
                button_moin.style.display = "none";
            });

        } else {

            button_plus.style.display = "none";
            button_moin.style.display = "none";
        }

    });

});
</script>


</html>