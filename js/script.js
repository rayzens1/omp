import { myFetch } from './fetch.js';
import { afficherEasteregg } from './easteregg.js';
import { afficheTabulator, clearTabulatorArea } from './tabulator.js';
import { showAlert } from './alert.js';
import { showAdminMenu, hideAdminMenu } from './adminMenu.js';

// Avec les modules on doit attacher la fonction accueil à la fenêtre du DOM
window.accueil = accueil;
window.closeModal = closeModal;

export function accueil() {
    manageLoginArea();
}

export function closeModal() {
    // On va fermer la modale pour le login
    document.getElementById('myModal').style.display = "none";
    // document.getElementById('modalFormContrainer').innerHTML = ''; // On vide la zone de login
}

function manageLoginArea() {
    // ON va appeler le serveu rpour consulter l'état de la session
    // Et afficher un module de login/logout en conséquence
    console.log('Login Area Trigger Debug')
    myFetch(null, afficheLoginZone, 'api.php?route=Session', 'GET')
}


const afficheLoginZone = function(sessionInfo) {
    console.log("Session Info :\n", sessionInfo);

    const loginArea = document.getElementById('loginArea');
    loginArea.innerHTML = ''; // On vide la zone de login
    if(sessionInfo.isLogged) {
        console.log("Je suis connecté !")
        console.log("id: "+sessionInfo.userInfo.id)
        // Si pas connecté, on affiche le formulaire de logout
        afficheLogout();
        afficheLogin(sessionInfo);
        
        // On affiche le menu admin si il est administrateur ou modérateur
        if(sessionInfo.userInfo.idRole >= 2) {
            showAdminMenu(loginArea);
        }
    } else {
        console.log("Je suis pas connecté !")
        let callBack = function(event) { doLogin(sessionInfo); };
        
        let aHrefLogin = document.createElement('a');
        aHrefLogin.setAttribute('href', '#');
        aHrefLogin.textContent = "S'indentifier";
        aHrefLogin.addEventListener('click', function(event) {
            event.preventDefault();
            callBack(event);
        });
        
        loginArea.appendChild(aHrefLogin);

        loginArea.appendChild(document.createElement('br')); // On ajoute un saut de ligne
        // LOGIN
        afficheRegister();
    }
}

function afficheLogout() {
    const container = document.getElementById('loginArea');

    let callBack = function() { doLogout(); };

    let aHrefLogout = document.createElement('a');
    aHrefLogout.setAttribute('href', '#');
    aHrefLogout.textContent = "Se déconnecter";
    aHrefLogout.addEventListener('click', function(event) {
        event.preventDefault();
        callBack(event);
    });

    container.appendChild(aHrefLogout);
}

function afficheRegister() {
    const container = document.getElementById('loginArea');

    let callBack = function(event) { doRegister(); };

    let aHrefLogout = document.createElement('a');
    aHrefLogout.setAttribute('href', '#');
    aHrefLogout.textContent = "Créer un compte";
    aHrefLogout.addEventListener('click', function(event) {
        event.preventDefault();
        callBack(event);
    });

    container.appendChild(aHrefLogout);
}

const afficheLogin = function(sessionInfo) {
    const container = document.getElementById('loginArea');
    const login = document.createElement('h1');
    console.log(sessionInfo.userInfo.login);
    login.textContent = `Bienvenue ${sessionInfo.userInfo.pseudo} !`;
    container.appendChild(login);
}

function prepareModal() {
    // On va créer une modale pour le login
    document.getElementById('myModal').style.display = "block";
    const container = document.getElementById('modalFormContainer');
    container.innerHTML = ''; // On vide la zone de login
    return container;
}

function clearLoginArea() {
    // On va vider la zone de login
    const container = document.getElementById('loginArea');
    container.innerHTML = ''; // On vide la zone de login
}

function doLogin(sessionInfo) {
    // On va appeler le serveur pour faire un login
    // Et afficher un module de login/logout en conséquence
    const container = prepareModal();
    const form = document.createElement('form');
    form.id = 'loginForm';

    
    const loginLabel = document.createElement('label');
    loginLabel.textContent = 'Email: ';
    form.appendChild(loginLabel);
    
    const loginInput = document.createElement('input');
    loginInput.type = 'email';
    loginInput.name = 'login';
    loginInput.id = 'login';
    loginInput.required = true;
    form.appendChild(loginInput);
    
    const passwordLabel = document.createElement('label');
    passwordLabel.textContent = 'Mot de passe: ';
    form.appendChild(passwordLabel);
    
    const passwordInput = document.createElement('input');
    passwordInput.type = 'password';
    passwordInput.name = 'password';
    passwordInput.id = 'password';
    passwordInput.required = true;
    form.appendChild(passwordInput);
    
    const routeInput = document.createElement('input');
    routeInput.type = 'text';
    routeInput.name = 'route';
    routeInput.id = 'route';
    routeInput.value = 'Login';
    routeInput.hidden = true;
    form.appendChild(routeInput);
    
    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.textContent = 'Se connecter';
    form.appendChild(submitButton);

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const dataCallback = function(event) {
            closeModal();
            clearLoginArea();
            afficheLogout();
            myFetch(null, afficheLoginZone, 'api.php?route=Session', 'GET') // Pas l'info du login
        };

        const errorCallback = function(error) {
            console.log(error.message);

            switch (error.message) {
                case "Invalid Credential":
                    showAlert("Votre login ou mot de passe est invalide ! ❌", "danger", container);
                    // alert("Votre login ou password est invalide ! ❌");
                    break;
                default:
                    showAlert(`${error.message} ❌`, "danger", container);
                    // alert(error.message+" ❌");
                    break;
            }
        }

        myFetch(new URLSearchParams(new FormData(form)), dataCallback, 'api.php', 'POST', errorCallback)

    });

    container.appendChild(form);
}

function doLogout() {
    clearTabulatorArea();
    myFetch(null, function() {myFetch(null, afficheLoginZone, 'api.php?route=Session', 'GET')}, 'api.php?route=Logout', 'GET')
}

function doRegister() {
    // On va appeler le serveur pour faire un login
    // Et afficher un module de login/logout en conséquence
    const container = prepareModal();
    const form = document.createElement('form');
    form.id = 'registerForm';

    // EMAIL
    const loginLabel = document.createElement('label');
    loginLabel.textContent = 'Email: ';
    form.appendChild(loginLabel);
    
    const loginInput = document.createElement('input');
    loginInput.type = 'email';
    loginInput.name = 'login';
    loginInput.id = 'login';
    loginInput.required = true;
    form.appendChild(loginInput);
    
    // MDP
    const passwordLabel = document.createElement('label');
    passwordLabel.textContent = 'Mot de passe: ';
    form.appendChild(passwordLabel);
    
    const passwordInput = document.createElement('input');
    passwordInput.type = 'password';
    passwordInput.name = 'password';
    passwordInput.id = 'password';
    passwordInput.required = true;
    form.appendChild(passwordInput);

    // CONFIRM MDP
    const passwordcLabel = document.createElement('label');
    passwordcLabel.textContent = 'Confirmer mot de passe: ';
    form.appendChild(passwordcLabel);
    
    const passwordcInput = document.createElement('input');
    passwordcInput.type = 'password';
    passwordcInput.name = 'passwordc';
    passwordcInput.id = 'passwordc';
    passwordcInput.required = true;
    form.appendChild(passwordcInput);

    // PSEUDO
    const pseudoLabel = document.createElement('label');
    pseudoLabel.textContent = 'Pseudo: ';
    form.appendChild(pseudoLabel);
    
    const pseudoInput = document.createElement('input');
    pseudoInput.type = 'text';
    pseudoInput.name = 'pseudo';
    pseudoInput.id = 'pseudo';
    pseudoInput.required = true;
    form.appendChild(pseudoInput);
    
    // Route
    const routeInput = document.createElement('input');
    routeInput.type = 'text';
    routeInput.name = 'route';
    routeInput.id = 'route';
    routeInput.value = 'Compte';
    routeInput.hidden = true;
    form.appendChild(routeInput);
    
    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.textContent = 'Créer un compte';
    form.appendChild(submitButton);

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const dataCallback = function(event) {
            closeModal();
            showAlert("Votre login ou mot de passe est invalide ! ❌", "success", container);
            //alert("Votre compte a été créé ! ✅");
        };

        const errorCallback = function(error) {
            console.log("err msg: "+error.message);
            console.log(error.message.split("-").length)
            if(error.message.split("-").length > 1) { // Possède un "-" tel que "Email already exists - Pseudo already exists"
                let msg = error.message.split("-")[1].trim();
                let msgObj = error.message.split("-")[0].trim(); // Permet de récupérer le 'columnName_UNIQUE'
                msgObj = msgObj.split("_")[0].trim()+"'"; // Enlève le _UNIQUE' de login_

                switch (msg) {
                    case "already exists":
                        //alert(`le ${msgObj} existe déjà ! ❌`);
                        showAlert(`le ${msgObj} existe déjà ! ❌`, "danger", container);
                        break;
                    default:
                        showAlert("Erreur inconnue ❌", "danger", container);
                        break;
                }
            } else { // Ne possède pas de "-" tels que "Email already exists"
                switch (error.message) {
                    case "Email already exists":
                        showAlert("Cet email existe déjà ! ❌", "danger", container);
                        //alert("Cet email existe déjà ! ❌");
                        break;
                    case "Pseudo already exists":
                        showAlert("Ce pseudo existe déjà ! ❌", "danger", container);
                        //alert("Ce pseudo existe déjà ! ❌");
                        break;
                    case "Password not same":
                        showAlert("Les mots de passe ne correspondent pas ! ❌", "danger", container);
                        //alert("Les mots de passe ne correspondent pas ! ❌");
                        break;
                    case "Invalid Credential":
                        showAlert("Votre login ou password est invalide ! ❌", "danger", container);
                        //alert("Votre login ou password est invalide ! ❌");
                        break;
                    case "Login already exists":
                        showAlert("Ce login existe déjà ! ❌", "danger", container);
                        //alert("Ce login existe déjà ! ❌");
                        break;
                    default:
                        showAlert("Erreur inconnue ❌", "danger", container);
                        // alert("Erreur inconnue ❌");
                        break;
                }
            }
        }

        myFetch(new URLSearchParams(new FormData(form)), dataCallback, 'api.php', 'POST', errorCallback)

    });

    container.appendChild(form);

}

// On va afficher le tableau de tabulator
function doTabulator() {
    
    myFetch(null, afficheTabulator, 'api.php?route=Compte&action=findall', 'GET')
}