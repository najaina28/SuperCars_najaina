/**
 * Fonctions Utilitaires SUPERCAR 🚗
 */

/**
 * Initialise le basculement de visibilité du mot de passe
 */
function initPasswordToggle() {
    document.querySelectorAll('.password-icon').forEach(icon => {
        icon.onclick = function () {
            let input = this.previousElementSibling;
            if (input) {
                input.type = (input.type === 'password') ? 'text' : 'password';
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            }
        };
    });
}

/**
 * Nettoie les paramètres GET de l'URL sans recharger la page
 * @param {Array} params - Liste des noms de paramètres à supprimer
 */
function cleanUrl(params = ['erreur', 'succes']) {
    if (window.history.replaceState) {
        const url = new URL(window.location);
        params.forEach(param => url.searchParams.delete(param));
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }
}

/**
 * Gère l'affichage des notifications et le nettoyage de l'URL
 * @param {string} erreur - Message d'erreur PHP
 * @param {string} succes - Message de succès PHP
 */
function handleNotifications(erreur = "", succes = "") {
    if (erreur && erreur !== "") {
        showNotification(erreur, "error");
    }
    if (succes && succes !== "") {
        showNotification(succes, "success");
    }

    // On nettoie l'URL après un léger délai pour être sûr que tout est chargé
    setTimeout(() => {
        cleanUrl(['erreur', 'succes']);
    }, 500);
}
