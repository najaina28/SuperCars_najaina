document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('search');
    const catalogueContainer = document.getElementById('catalogue');
    const list = document.getElementById('suggestions');

    // Initialisation : trouver le bouton actif au chargement
    const activeBtn = document.querySelector('.filter-btn.active');
    let currentMarqueId = activeBtn ? activeBtn.getAttribute('data-marque-id') : 0;

    let timer;

    // Fonction pour charger les véhicules filtrés
    function loadVehicles(marqueId = 0, indice = "") {
        // Ajout d'un effet de chargement (opacité)
        catalogueContainer.style.opacity = '0.5';

        const url = `backend/filtreCatalogue.php?marque_id=${marqueId}&indice=${encodeURIComponent(indice)}`;

        fetch(url)
            .then(response => response.text())
            .then(data => {
                catalogueContainer.innerHTML = data;
                catalogueContainer.style.opacity = '1';

                // Animation progressive des résultats
                const newCards = catalogueContainer.querySelectorAll('.col-md-4');
                newCards.forEach((card, index) => {
                    card.classList.add('car-item-animate');
                    card.style.animationDelay = (index * 0.05) + 's';
                });

                // Mettre à jour l'URL sans recharger la page
                const newUrl = new URL(window.location);
                if (marqueId != 0) newUrl.searchParams.set('marque_id', marqueId);
                else newUrl.searchParams.delete('marque_id');

                if (indice !== "") newUrl.searchParams.set('indice', indice);
                else newUrl.searchParams.delete('indice');

                window.history.replaceState({}, '', newUrl);
            })
            .catch(error => {
                console.error('Erreur lors du filtrage:', error);
                catalogueContainer.style.opacity = '1';
            });
    }

    // Gestion des clics sur les boutons de filtrage
    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Mise à jour visuelle des boutons
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'btn-orange');
                btn.classList.add('btn-light');
            });
            this.classList.add('active', 'btn-orange');
            this.classList.remove('btn-light');

            currentMarqueId = this.getAttribute('data-marque-id');
            // Réinitialiser la recherche lors du changement de marque (selon le comportement souhaité)
            // searchInput.value = ""; 

            loadVehicles(currentMarqueId, searchInput.value);
        });
    });

    // Gestion de la recherche (avec un léger délai pour éviter trop de requêtes)
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(() => {
                loadVehicles(currentMarqueId, this.value);
            }, 300);

            // Gestion de l'autocomplétion
            if (list) {
                const value = this.value.toLowerCase().trim();
                list.innerHTML = ""; // On vide la liste à chaque nouvelle lettre
                
                if (value.length >= 1 && typeof suggestionsData !== 'undefined') {
                    const filtered = suggestionsData.filter(item => {
                        const texteAComparer = (typeof item === 'object' && item !== null) ? item.modele : item;
                        return texteAComparer && texteAComparer.toLowerCase().includes(value);
                    });

                    filtered.forEach(item => {
                        const li = document.createElement("li");
                        const nomModele = (typeof item === 'object') ? item.modele : item;
                        li.textContent = nomModele;

                        li.addEventListener("click", () => {
                            searchInput.value = nomModele;
                            list.innerHTML = "";
                            // Déclencher artificiellement l'événement input pour AJAX
                            const event = new Event('input', { bubbles: true });
                            searchInput.dispatchEvent(event);
                        });

                        list.appendChild(li);
                    });
                }
            }
        });
        
        // Cacher les suggestions en cliquant ailleurs
        document.addEventListener('click', function(e) {
            if (list && e.target !== searchInput && e.target !== list) {
                list.innerHTML = "";
            }
        });
    }

    // Empêcher la soumission des formulaires si l'utilisateur appuie sur "Entrée"
    const searchForm = document.getElementById('search-form');
    if (searchForm) searchForm.addEventListener('submit', (e) => e.preventDefault());
    
    const filterForm = document.getElementById('filter-form');
    if (filterForm) filterForm.addEventListener('submit', (e) => e.preventDefault());

    // Animation initiale au chargement de la page
    if (catalogueContainer) {
        const initialCards = catalogueContainer.querySelectorAll('.col-md-4');
        initialCards.forEach((card, index) => {
            card.classList.add('car-item-animate');
            card.style.animationDelay = (index * 0.05) + 's';
        });
    }
});
