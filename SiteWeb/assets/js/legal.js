/**
 * Affiche les mentions légales ou la politique de confidentialité dans un modal dynamique
 * @param {string} type - 'conditions' ou 'politique'
 */
function showLegal(type) {
    const legalData = {
        'conditions': {
            title: 'Mentions Légales & Conditions d\'utilisation',
            content: `
                <div class="legal-content">
                    <h6>Nom du site :</h6>
                    <p>Supercar</p>

                    <h6>Responsables du projet :</h6>
                    <p>ANDRIAMIFIDISOA Heritiana Cedric, <br>RAZANADRAKOTO Herintsoa Fitahiana <br>RAMANITRINIHAJA Najaina Liantsoa<br>
                    Étudiants en BTS SIO – Réalisation Professionnelle<br>
                    MCCI Business School<br>
                    Rue Savoir, Cybercity, Ebene, Maurice</p>

                    <h6>Propriété intellectuelle :</h6>
                    <p>L'ensemble du contenu de ce site, incluant textes, images, logos et vidéos, est protégé par le droit d'auteur. Toute reproduction, représentation ou diffusion, totale ou partielle, est interdite sans autorisation préalable des auteurs.</p>

                    <h6>Données personnelles :</h6>
                    <p>Aucune donnée personnelle n'est directement vendue ou cédée. Les informations collectées lors de l'inscription sont utilisées uniquement pour la gestion de votre compte et de vos demandes d'essai.</p>

                    <h6>Limitation de responsabilité :</h6>
                    <p>Ce site est un prototype académique réalisé dans le cadre d'un projet étudiant. Il n'a pas vocation à représenter une entreprise réelle. Les informations présentées sont fournies à titre indicatif.</p>
                </div>
            `
        },
        'politique': {
            title: 'Politique de Confidentialité',
            content: `
                <div class="legal-content">
                    <h6>Introduction</h6>
                    <p>Cette politique explique comment nous traitons les informations que vous nous fournissez lors de votre inscription.</p>

                    <h6>Collecte des données</h6>
                    <p>Nous collectons votre nom, prénom, email et téléphone lors de la création de votre compte. Ces données sont essentielles pour traiter vos demandes d'essai de véhicules.</p>

                    <h6>Utilisation des données</h6>
                    <p>Vos données sont utilisées exclusivement pour :
                        <ul>
                            <li>Gérer votre compte utilisateur</li>
                            <li>Vous recontacter concernant vos demandes d'essai</li>
                            <li>Améliorer nos services</li>
                        </ul>
                    </p>

                    <h6>Sécurité</h6>
                    <p>Nous mettons en œuvre des mesures de sécurité pour protéger vos données contre tout accès non autorisé (hachage des mots de passe, sessions sécurisées).</p>

                    <h6>Vos droits</h6>
                    <p>Vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles via votre espace profil.</p>
                </div>
            `
        }
    };

    const data = legalData[type];
    if (!data) return;

    // Créer le modal s'il n'existe pas
    let modalElement = document.getElementById('dynamicLegalModal');
    if (!modalElement) {
        modalElement = document.createElement('div');
        modalElement.id = 'dynamicLegalModal';
        modalElement.className = 'modal fade';
        modalElement.setAttribute('tabindex', '-1');
        modalElement.innerHTML = `
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div class="modal-header" style="border-bottom: 1px solid #eee; padding: 20px 30px;">
                        <h5 class="modal-title fw-bold" id="legalTitle" style="color: #333;"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="legalBody" style="padding: 30px; font-size: 15px; color: #555; line-height: 1.6;">
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #eee; padding: 15px 30px;">
                        <button type="button" class="btn" data-bs-dismiss="modal" style="background: #E67E22; color: white; border-radius: 10px; padding: 8px 25px; font-weight: 600;">Compris</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modalElement);
    }

    // Mettre à jour le contenu
    document.getElementById('legalTitle').innerText = data.title;
    document.getElementById('legalBody').innerHTML = data.content;

    // Afficher le modal (en utilisant l'API de Bootstrap)
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}
