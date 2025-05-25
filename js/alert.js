export function showAlert(messageAlert, type, container) {
    
    let alertDiv = container.querySelector("#notification");

    if (!alertDiv) {
        alertDiv = document.createElement('div');
        alertDiv.id = 'notification';
        container.appendChild(alertDiv);
    }

    // 1) Réinitialiser le conteneur
    alertDiv.className = '';
    alertDiv.innerHTML = '';

    // 2) Ajouter les classes de base (sans encore "show")
    alertDiv.classList.add(
        'alert',
        `alert-${type}`,
        'alert-dismissible',
        'fade'
    );

    // 3) Créer et ajouter le bouton de fermeture
    const closeBtn = document.createElement('button');
    closeBtn.setAttribute('type', 'button');
    closeBtn.classList.add('btn-close');
    closeBtn.setAttribute('data-bs-dismiss', 'alert');
    closeBtn.setAttribute('aria-label', 'Close');
    alertDiv.appendChild(closeBtn);

    // 5) Texte de l’alerte
    alertDiv.appendChild(document.createTextNode(messageAlert));

    // 6) Forcer une frame avant d’ajouter "show" pour lancer la transition
    requestAnimationFrame(() => {
        alertDiv.classList.add('show');
    });
}