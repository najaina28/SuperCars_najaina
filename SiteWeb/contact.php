<?php
session_start();
require_once 'backend/fonctionsLogin.php';
require_once 'backend/fonctionContenu.php';

$contact_contents = get_all_contenu_by_page($bdd, 'contact');
$phone    = find_contenu($contact_contents, 1);
$email    = find_contenu($contact_contents, 2);
$adresse  = find_contenu($contact_contents, 3);
$lun_ven  = find_contenu($contact_contents, 4);
$samedi   = find_contenu($contact_contents, 5);
$dimanche = find_contenu($contact_contents, 6);
$gmap     = find_contenu($contact_contents, 7);

$id_client = $_SESSION['id_client'] ?? 0;
$is_connected = ($id_client > 0);

// Récupération des infos (depuis la base si connecté, depuis la session sinon)
if ($is_connected) {
    $client = getClientById($id_client);
    $prenom    = $client['prenom']    ?? '';
    $nom       = $client['nom']       ?? '';
    $mail      = $client['mail']      ?? '';
    $telephone = $client['telephone'] ?? '';
} else {
    $prenom    = $_SESSION['prenom']    ?? '';
    $nom       = $_SESSION['nom']       ?? '';
    $mail      = $_SESSION['mail']      ?? '';
    $telephone = $_SESSION['telephone'] ?? '';
}


// Traitement du formulaire
$feedback = null;
if (!empty($_SESSION['message_ok'])) {
    $feedback = ['success' => true, 'message' => "Votre message a été envoyé avec succès !"];
    unset($_SESSION['message_ok']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'backend/FonctionMessage.php';

    $prenom = trim($_POST['prenom'] ?? '');
    $nom    = trim($_POST['nom']    ?? '');
    $mail   = trim($_POST['email']  ?? '');
    $msg    = trim($_POST['message'] ?? '');

    if (!empty($msg)) {
        ajouterMessageClient($id_client, $msg, $prenom, $nom, $mail, $_POST['telephone'] ?? '');
        $_SESSION['message_ok'] = true;
        header("Location: contact.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperCar – Contact</title>

    <!-- Fichiers CSS Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icônes Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <!-- Ton style personnalisé -->
    <link href="assets/css/contact.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/notifications.css">
</head>


<body>

    <!-- Menu de navigation -->
    <?php include('include/header.php'); ?>

    <!-- Bannière d'en-tête -->
    <div class="page-header">
        <div class="container px-4">
            <div class="header-accent"></div>
            <h1>Contactez-nous</h1>
            <p>Notre équipe est disponible pour répondre à toutes vos questions et vous accompagner dans votre projet automobile.</p>
        </div>
    </div>

    <!-- Message de feedback après envoi -->
    <?php if ($feedback): ?>
    

    <?php endif; ?>

    <!-- INFO CARDS -->
    <section class="info-strip">
        <div class="container px-4">
            <div class="row g-3 justify-content-center">

                <div class="col-lg-3 col-md-6">
                    <div class="info-card">
                        <div class="icon-circle"><i class="bi bi-telephone-fill"></i></div>
                        <h5>Téléphone</h5>
                        <p><a href="tel:<?= preg_replace('/\s+/', '', $phone['titre'] ?? '0322565478') ?>"><?= htmlspecialchars($phone['titre'] ?? '0322 565 478') ?></a></p>
                        <p style="margin-top:.2rem;font-size:.78rem;color:#aaa;"><?= htmlspecialchars($phone['texte'] ?? 'Lun–Ven 08h–18h') ?></p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="info-card">
                        <div class="icon-circle"><i class="bi bi-envelope-fill"></i></div>
                        <h5>Email</h5>
                        <p><a href="mailto:<?= htmlspecialchars($email['titre'] ?? 'supercar@gmail.com') ?>"><?= htmlspecialchars($email['titre'] ?? 'supercar@gmail.com') ?></a></p>
                        <p style="margin-top:.2rem;font-size:.78rem;color:#aaa;"><?= htmlspecialchars($email['texte'] ?? 'Réponse sous 24h') ?></p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="info-card">
                        <div class="icon-circle"><i class="bi bi-geo-alt-fill"></i></div>
                        <h5>Adresse</h5>
                        <p><?= htmlspecialchars($adresse['titre'] ?? 'MCCI Business School, Ebene, Maurice') ?></p>
                        <?php if (!empty($adresse['texte'])): ?>
                            <p style="margin-top:.2rem;font-size:.78rem;color:#aaa;"><?= htmlspecialchars($adresse['texte']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="main-section">
        <div class="container px-4">
            <div class="row g-4">

                <!-- LEFT : Formulaire + Horaires -->
                <div class="col-lg-5">

                    <div class="form-card">
                        <div class="form-card-title">
                            <span></span> Envoyez-nous un message
                        </div>

                        <form action="" method="post">
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label">Prénom <span class="req">*</span></label>
                                    <input type="text" name="prenom" class="form-control" 
                                           value="<?= htmlspecialchars($prenom) ?>" required <?= $is_connected ? 'readonly' : '' ?>>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Nom <span class="req">*</span></label>
                                    <input type="text" name="nom" class="form-control" 
                                           value="<?= htmlspecialchars($nom) ?>" required <?= $is_connected ? 'readonly' : '' ?>>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="req">*</span></label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= htmlspecialchars($mail) ?>" required <?= $is_connected ? 'readonly' : '' ?>>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="telephone" class="form-control" 
                                       value="<?= htmlspecialchars($telephone) ?>" <?= $is_connected ? 'readonly' : '' ?>>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Message <span class="req">*</span></label>
                                <textarea name="message" class="form-control" rows="6"
                                    placeholder="Décrivez votre demande en détail (projet, achat, SAV, question...)" required></textarea>
                            </div>

                            <button type="submit" class="btn-send">
                                <i class="bi bi-send-fill me-2"></i>Envoyer le message
                            </button>
                        </form>
                    </div>

                    <!-- Horaires -->
                    <div class="hours-banner">
                        <h5><i class="bi bi-clock-fill"></i> Heures d'ouverture</h5>
                        <div class="hours-row">
                            <span class="hours-day"><?= htmlspecialchars($lun_ven['titre'] ?? 'Lundi – Vendredi') ?></span>
                            <span class="hours-time"><?= htmlspecialchars($lun_ven['texte'] ?? '08h00 – 18h00') ?></span>
                            <span class="open-pill">Ouvert</span>
                        </div>
                        <div class="hours-row">
                            <span class="hours-day"><?= htmlspecialchars($samedi['titre'] ?? 'Samedi') ?></span>
                            <span class="hours-time"><?= htmlspecialchars($samedi['texte'] ?? '09h00 – 17h00') ?></span>
                            <span class="open-pill">Ouvert</span>
                        </div>
                        <div class="hours-row">
                            <span class="hours-day"><?= htmlspecialchars($dimanche['titre'] ?? 'Dimanche') ?></span>
                            <span class="hours-time closed"><?= htmlspecialchars($dimanche['texte'] ?? '10h00 – 15h00') ?></span>
                        </div>
                    </div>

                </div>

                <!-- RIGHT : Carte -->
                <div class="col-lg-7">
                    <div class="map-card">
                        <div class="map-card-header">
                            <h5><i class="bi bi-map-fill"></i> Nous trouver</h5>
                            <p><?= htmlspecialchars($gmap['titre'] ?? 'MCCI Business School — Showroom principal SUPERCAR') ?></p>
                        </div>

                        <iframe
                            src="<?= htmlspecialchars($gmap['texte'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1198.5492211244302!2d57.48494871408381!3d-20.24355594411807!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c5b16955dcd29%3A0xe6719b48c3b7a89a!2sMCCI%20Business%20School!5e0!3m2!1sfr!2smu!4v1700000000000!5m2!1sfr!2smu') ?>"
                            width="100%" style="min-height:380px; border:none; display:block;" loading="lazy"
                            title="Localisation SUPERCAR" allowfullscreen>
                        </iframe>

                        <div class="map-card-footer">
                            <div class="map-badge">
                                <i class="bi bi-train-front-fill"></i>
                                <span>Metro Express – Station d'Ebene</span>
                            </div>
                            <div class="map-badge">
                                <i class="bi bi-p-circle-fill"></i>
                                <span>Parking disponible</span>
                            </div>
                            <a class="btn-directions"
                               href="https://www.google.com/maps/dir/?api=1&destination=MCCI+Business+School+Ebene"
                               target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-signpost-split-fill"></i> Itinéraire
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include('include/footer.html'); ?>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/notifications.js"></script>
    <script src="assets/js/supercar.js"></script>
    <script>
        window.onload = function () {
            <?php if ($feedback): ?>
                showNotification("<?= htmlspecialchars($feedback['message']) ?>", "<?= $feedback['success'] ? 'success' : 'error' ?>");
            <?php endif; ?>
        };
    </script>
</body>


</html>