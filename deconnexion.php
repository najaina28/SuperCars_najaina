<?php
session_start();

// Si l'utilisateur a confirmé la déconnexion
if (isset($_POST['confirmer']) && $_POST['confirmer'] == 'oui') {
    session_unset();
    session_destroy();
    header('location: loginAdmin.php?succes=deconnexion');
    exit();
}

// Si l'utilisateur a annulé, on le renvoie au profil ou à l'accueil
if (isset($_POST['annuler'])) {
    header('location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion Admin - SUPERCAR</title>

    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


    <style>
        /* Thème sombre du dashboard */
        :root {
            --admin-bg: #0f1115;
            --admin-card: #16191f;
            --admin-text: #e0e0e0;
            --admin-accent: #E67E22;
            --admin-border: #232730;
        }

        body {
            background-color: var(--admin-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: var(--admin-text);
        }

        .logout-card {
            background: var(--admin-card);
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            max-width: 450px;
            width: 100%;
            text-align: center;
            border: 1px solid var(--admin-border);
        }

        .brand-logo {
            width: 120px;
            margin-bottom: 25px;
            filter: brightness(0) invert(1);
        }

        .logout-icon {
            font-size: 45px;
            color: var(--admin-accent);
            margin-bottom: 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: rgba(230, 126, 34, 0.1);
            border-radius: 50%;
        }

        .logout-title {
            font-size: 24px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 15px;
        }

        .logout-text {
            color: #aaaaaa;
            margin-bottom: 35px;
            font-size: 15px;
            line-height: 1.5;
        }

        .logout-text strong {
            color: #ffffff;
        }

        .btn-action {
            width: 100%;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            margin-bottom: 12px;
            border: none;
            cursor: pointer;
        }

        .btn-confirm {
            background-color: var(--admin-accent);
            color: #ffffff;
        }

        .btn-confirm:hover {
            background-color: #d35400;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background-color: transparent;
            color: #888888;
            border: 1px solid var(--admin-border);
        }

        .btn-cancel:hover {
            background-color: var(--admin-border);
            color: #ffffff;
        }
    </style>
</head>

<body>

    <div class="logout-card">
        <img src="assets/images/logo.png" alt="Supercar" class="brand-logo">
        <br>
        <div class="logout-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h1 class="logout-title">Fermeture de session</h1>
        <p class="logout-text">Êtes-vous sûr de vouloir vous déconnecter de votre <strong>Espace Administration</strong> ?</p>

        <form method="POST">
            <button type="submit" name="confirmer" value="oui" class="btn-action btn-confirm">Oui, me déconnecter</button>
            <button type="submit" name="annuler" value="non" class="btn-action btn-cancel">Annuler et retourner au tableau de bord</button>
        </form>
    </div>

</body>

</html>
