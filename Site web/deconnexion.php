<?php
session_start();

// Si l'utilisateur a confirmé la déconnexion
if (isset($_POST['confirmer']) && $_POST['confirmer'] == 'oui') {
    session_unset();
    session_destroy();
    header('location: login.php?succes=deconnexion');
    exit();
}

// Si l'utilisateur a annulé, on le renvoie au profil ou à l'accueil
if (isset($_POST['annuler'])) {
    header('location: profil.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion - SUPERCAR</title>

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .logout-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            max-width: 450px;
            width: 100%;
            text-align: center;
        }

        .logout-icon {
            font-size: 60px;
            color: #E67E22;
            margin-bottom: 20px;
            display: inline-block;
        }

        .logout-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .logout-text {
            color: #666;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .btn-logout {
            background-color: #E67E22;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-logout:hover {
            background-color: #d35400;
            color: white;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background-color: transparent;
            color: #999;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-cancel:hover {
            background-color: #f1f1f1;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="logout-card">
        <div class="logout-icon">
            <i class="bi bi-box-arrow-right"></i>
        </div>
        <h1 class="logout-title">Déconnexion</h1>
        <p class="logout-text">Êtes-vous sûr de vouloir vous déconnecter de votre espace client
            <strong>SUPERCAR</strong> ?</p>

        <form method="POST">
            <button type="submit" name="confirmer" value="oui" class="btn-logout">Oui, me déconnecter</button>
            <button type="submit" name="annuler" value="non" class="btn-cancel">Annuler</button>
        </form>
    </div>

</body>

</html>