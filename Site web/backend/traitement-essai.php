<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: catalogue.php');
    exit();
}

include 'connexion.php'; // votre fichier de connexion



$id_client   = $_SESSION['id_client']   ?? 0;
$id_voiture  = (int)($_POST['id_voiture']  ?? 0);
$date_essai  = $_POST['date_essai']    ?? '';
$message     = trim($_POST['message']  ?? '');


if ($id_client <= 0 || $id_voiture <= 0 || empty($date_essai)) {
    $_SESSION['message'] = "Données incomplètes. Veuillez réessayer.";
    header('Location: demande-essaiDetails.php?id=' . $id_voiture);
    exit();
}

$check = $bdd->prepare("
    SELECT id_demande 
    FROM demande_essai 
    WHERE idvoiture = ? AND id_client = ?
");

$check->bind_param("ii", $id_voiture, $id_client);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    $_SESSION['message'] = "Vous avez déjà fait une demande d'essai pour cette voiture.";
    header("Location: /Supercar git/demande-essaiDetails.php?id=$id_voiture");
    exit();
}

// Insertion
$stmt = $bdd->prepare("
    INSERT INTO demande_essai 
    (date_essai, statut, idvoiture, id_client) 
    VALUES (?, 'en_cours', ?, ?)
");

if (!$stmt) {
    die("Erreur prepare : " . $bdd->error);
}

$stmt->bind_param("sii", $date_essai, $id_voiture, $id_client);

if ($stmt->execute()) {
    $_SESSION['message'] = "Votre demande d'essai a bien été enregistrée ! Nous vous contacterons rapidement.";
} else {
    $_SESSION['message'] = "Une erreur est survenue. Veuillez réessayer.";
}

header("Location: demande-essaiDetails.php?id=$id_voiture");
exit();