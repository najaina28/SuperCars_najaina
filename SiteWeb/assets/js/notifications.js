function showNotification(message, type = 'success') {
    // Créer le container s'il n'existe pas
    let container = document.querySelector('.notification-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'notification-container';
        document.body.appendChild(container);
    }

    // Créer la notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;

    const iconClass = type === 'success' ? 'bi-check-lg' : 'bi-exclamation-triangle';
    notification.innerHTML = `
        <div class="notification-icon">
            <i class="bi ${iconClass}"></i>
        </div>
        <div class="notification-content">
            <span class="message">${message}</span>
        </div>
        <div class="notification-close">
            <i class="bi bi-x-lg"></i>
        </div>
        <div class="notification-progress"></div>
    `;

    container.appendChild(notification);

    // Event de fermeture manuelle
    notification.querySelector('.notification-close').onclick = () => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 500);
    };

    // Animation d'entrée
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    // Auto-suppression après 5 secondes
    setTimeout(() => {
        if (notification.parentElement) {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }, 5000);
}
