<!-- ── CHECKBOX HACK POUR MENU MOBILE (SANS JS) ── -->
<input type="checkbox" id="sidebar-toggle-input">

<!-- ── BOUTON MOBILE (SANS JS) ── -->
<label for="sidebar-toggle-input" class="mobile-nav-btn">
    <i class="bi bi-list"></i>
</label>

<!-- ── OVERLAY MOBILE (SANS JS) ── -->
<label for="sidebar-toggle-input" class="sidebar-overlay"></label>

<!-- ── SIDEBAR ── -->
<aside id="sidebar">
    <div class="brand">
        <?php
            if (file_exists("assets/images/logo.png")) {
                $logo = "assets/images/logo.png";
            } else {
                $logo = "../../assets/images/logo.png";
            }
        ?>

<img src="<?php echo $logo; ?>" alt="Supercar" class="brand-logo">    

        <div class="brand-sub">Administration</div>
        <!--<?php/// if (isset($_SESSION['prenom'])): ?>
        <div class="brand-admin-name">
            <i class="bi bi-person-fill"></i>
            <?php// htmlspecialchars($_SESSION['prenom'] . ' ' . ($_SESSION['nom'] ?? '')) ?>
        </div> -->
        <?php// endif; ?>
    </div>

    <nav>
        <div class="nav-section">Principal</div>

        <?php
            if (file_exists("tableauBord.php")) {
                $tabbord = "tableauBord.php";
            } else {
                $tabbord = "../../tableauBord.php";
            }
        ?>

        <a href="<?php echo $tabbord; ?>" class="nav-item">
            <i class="bi bi-speedometer2"></i>
            Tableau de bord
        </a>

        <details>
            <summary>
                <div class="nav-dropdown-title">
                    <i class="bi bi-house-door"></i>
                    <span>Gestion Accueil</span>
                    <i class="bi bi-chevron-down chevron"></i>
                </div>
            </summary>
            <div class="nav-sub">

            <?php
            if (file_exists("section_hero.php")) {
                $hero = "section_hero.php";
            } else {
                $hero = "../../section_hero.php";
            }
            ?>
                <a href="<?php echo $hero; ?>" class="nav-sub-item">Section Hero</a>
            <?php
            if (file_exists("section_apropos.php")) {
                $apropos = "section_apropos.php";
            } else {
                $apropos = "../../section_apropos.php";
            }
            ?>
                <a href="<?php echo $apropos; ?>" class="nav-sub-item">Section À propos</a>

            <?php
            if (file_exists("section_processus.php")) {
                $processus = "section_processus.php";
            } else {
                $processus = "../../section_processus.php";
            }
            ?>
                <a href="<?php echo $processus; ?>" class="nav-sub-item">Section Processus</a>
            </div>
        </details>

        <?php
            if (file_exists("liste_voiture.php")) {
                $voiture = "liste_voiture.php";
            } else {
                $voiture = "../../liste_voiture.php";
            }
        ?>
        <a href="<?php echo $voiture; ?>" class="nav-item">
            <i class="bi bi-car-front"></i>
            Voitures
        </a>

        <div class="nav-section">Interactions</div>

        <?php
            if (file_exists("demande_essaie.php")) {
                $essai = "demande_essaie.php";
            } else {
                $essai = "../../demande_essaie.php";
            }
        ?>
        <a href="<?php echo $essai; ?>" class="nav-item">
            <i class="bi bi-calendar-check"></i>
            Demandes d'essai
        </a>

        <?php
            if (file_exists("liste_service.php")) {
                $service_link = "liste_service.php";
            } else {
                $service_link = "../../liste_service.php";
            }
        ?>
        <a href="<?php echo $service_link; ?>" class="nav-item">
            <i class="bi bi-wrench-adjustable"></i>
            Services
        </a>

        <?php
            if (file_exists("contact.php")) {
                $messages_link = "contact.php";
            } else {
                $messages_link = "../../contact.php";
            }
        ?>
        <a href="<?php echo $messages_link; ?>" class="nav-item">
            <i class="bi bi-chat-left-text"></i>
            Messages
        </a>

        <?php
            if (file_exists("section_contact.php")) {
                $contact_sec = "section_contact.php";
            } else {
                $contact_sec = "../../section_contact.php";
            }
        ?>
        <a href="<?php echo $contact_sec; ?>" class="nav-item">
            <i class="bi bi-geo-alt"></i>
            Infos Contact
        </a>

        <div class="nav-section">Compte</div>

        <a href="profil.php" class="nav-item">
            <i class="bi bi-person-circle"></i>
            Mon profil
        </a>
    </nav>

    <div class="sidebar-bottom">
        <a href="../index.php" class="nav-item">
            <i class="bi bi-arrow-return-left"></i>
            Retour au site
        </a>
        <a href="deconnexion.php" class="nav-item nav-logout">
            <i class="bi bi-box-arrow-left"></i>
            Déconnexion
        </a>
    </div>
</aside>
