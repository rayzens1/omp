import { afficheTabulatorUser, clearTabulatorArea } from "./tabulatorUser.js";
import { afficheTabulatorArticle } from "./tabulatorArticle.js";
import { myFetch } from "./fetch.js";

export function showAdminMenu(container) {
  // 1) Supprimer l'ancien menu s'il existe
  const old = container.querySelector('#adminMenu');
  if (old) old.remove();

  // 2) Créer le groupe de boutons
  const adminMenu = document.createElement('div');
  adminMenu.id = 'adminMenu';
  adminMenu.classList.add('btn-group');
  adminMenu.setAttribute('role', 'group');
  adminMenu.setAttribute('aria-label', 'Admin menu');

  // 3) Définir les options
  const options = [
    {
      id: 'option1',
      label: 'User',
      action: () => myFetch(null, afficheTabulatorUser, 'api.php?route=Compte&action=findall', 'GET'),
      clearCallback: clearTabulatorArea,
      roleIdRequired: 2
    },
    {
      id: 'option2',
      label: 'Article',
      action: () => myFetch(null, afficheTabulatorArticle, 'api.php?route=Article&action=findall', 'GET'),
      clearCallback: clearTabulatorArea,
      roleIdRequired: 2
    },
    {
      id: 'option3',
      label: 'Autre',
      action: () => console.log('Action Autre'),
      clearCallback: () => console.log('clear Autre')
    }
  ];

  options.forEach((opt, idx) => {
    
    const input = document.createElement('input');
    input.type = 'radio';
    input.classList.add('btn-check');
    input.name = 'adminOptions';
    input.id = opt.id;
    input.autocomplete = 'off';
    // if (idx === 0) input.checked = true; // Le premier bouton est sélectionné par défaut
    adminMenu.appendChild(input);

    // b) le <label> qui fait office de bouton
    const label = document.createElement('label');
    label.classList.add('btn', 'btn-outline-secondary');
    label.setAttribute('for', opt.id);
    label.textContent = opt.label;
    adminMenu.appendChild(label);
  });

  let previousOption = options[0];

  adminMenu.addEventListener('change', e => {
    const { target } = e;
    if (target.matches('input[name="adminOptions"]')) {
      // clear de l'ancienne option
      if (previousOption.clearCallback) {
        previousOption.clearCallback();
      }
      // exécuter la nouvelle action
      const selectedOpt = options.find(o => o.id === target.id);
      if (selectedOpt && selectedOpt.action) {
        selectedOpt.action();
      }
      previousOption = selectedOpt;
      console.log('Tu as cliqué sur :', target.id);
    }
  });

  // 4) Injecter dans le container passé en paramètre
  container.appendChild(adminMenu);
}

export function hideAdminMenu(container) {
    const adminMenu = container.querySelector('#adminMenu');
    if (adminMenu) {
        container.removeChild(adminMenu);
    }
}