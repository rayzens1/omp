import { myFetch } from './fetch.js';

export const afficheTabulatorUser = function(data) {

    let roleMap = {};
    
    const container = document.getElementById('example-table');
    container.style.borderBottom = '5px solid #222';

    fetch('api.php?route=Role&action=findall')
    .then(response => {
      if (!response.ok) {
        throw new Error(`Erreur réseau (${response.status})`);
      }
      return response.json();
    })
    .then(json => {
      if (!Array.isArray(json.data)) {
        throw new Error('Format inattendu de la réponse rôles');
      }
      json.data.forEach(({ idRole, label }) => {
        roleMap[label] = label;
      });
      roleMap;
    });

    // console.log("roleMap :\n", roleMap);

    new Tabulator("#example-table", {
        data: data.data,
        layout: "fitColumns",
        responsiveLayout: "hide",
        addRowPos: "top",
        history: true,
        pagination: "local",
        paginationSize: 15,
        paginationCounter: "rows",
        movableColumns: true,

        // 1) On désactive l’auto-génération
        autoColumns: false,

        // 2) On déclare manuellement les colonnes et on active l’éditeur
        columns: [
            { title: "ID", field: "idCompte", headerFilter: "input" },

            { title: "Login", field: "login", editor: "input", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idCompte = cell.getRow().getData().idCompte;

                    const myForm = new FormData();
                    myForm.append("route", "Compte")
                    myForm.append("id", idCompte);
                    myForm.append("action", key);
                    myForm.append(key, newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }
                    
                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "Mot de passe", field: "password", editor: "input", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idCompte = cell.getRow().getData().idCompte;

                    const myForm = new FormData();
                    myForm.append("route", "Compte")
                    myForm.append("id", idCompte);
                    myForm.append("action", key);
                    myForm.append(key, newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }

                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "Pseudo", field: "pseudo", editor: "input", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idCompte = cell.getRow().getData().idCompte;

                    const myForm = new FormData();
                    myForm.append("route", "Compte")
                    myForm.append("id", idCompte);
                    myForm.append("action", key);
                    myForm.append(key, newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }

                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "Date création", field: "dateCreation", editor: "date", editorParams: {format: "yyyy-MM-dd hh:mm:ss"}, headerFilter: "date" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idCompte = cell.getRow().getData().idCompte;

                    console.log(typeof newValue + " : " + newValue);

                    const myForm = new FormData();
                    myForm.append("route", "Compte")
                    myForm.append("id", idCompte);
                    myForm.append("action", key);
                    myForm.append(key, newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }

                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "Date modif.", field: "dateModification", editor: "date", editorParams: {format: "yyyy-MM-dd hh:mm:ss"}, headerFilter: "date" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idCompte = cell.getRow().getData().idCompte;

                    const myForm = new FormData();
                    myForm.append("route", "Compte")
                    myForm.append("id", idCompte);
                    myForm.append("action", key);
                    myForm.append(key, newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }

                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "estSupprime", field: "estSupprime", editor: true, formatter:"tickCross" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idCompte = cell.getRow().getData().idCompte;

                    const myForm = new FormData();
                    myForm.append("route", "Compte")
                    myForm.append("id", idCompte);
                    myForm.append("action", key);
                    myForm.append(key, + newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }

                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "estSignale", field: "estSignale", editor: true, formatter:"tickCross" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idCompte = cell.getRow().getData().idCompte;

                    const myForm = new FormData();
                    myForm.append("route", "Compte")
                    myForm.append("id", idCompte);
                    myForm.append("action", key);
                    myForm.append(key, + newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }

                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "estBanni", field: "estBanni", editor: true, formatter:"tickCross" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idCompte = cell.getRow().getData().idCompte;

                    const myForm = new FormData();
                    myForm.append("route", "Compte")
                    myForm.append("id", idCompte);
                    myForm.append("action", key);
                    myForm.append(key, + newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }
                    
                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "enAttenteDeModeration", field: "enAttenteDeModeration", editor: true, formatter:"tickCross",
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idCompte = cell.getRow().getData().idCompte;

                    const myForm = new FormData();
                    myForm.append("route", "Compte")
                    myForm.append("id", idCompte);
                    myForm.append("action", key);
                    myForm.append(key, + newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }
                    
                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);
                    
                }
            }, // headerFilter: "tickCross"

            { title: "Rôle", field: "role.label", formatter: "plaintext", editor: "list", headerFilter: "input",
                editorParams: {
                    allowEmpty: false,
                    values: roleMap
                },
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const idCompte = cell.getRow().getData().idCompte;

                    let roleId;

                    const callback = function(data) {
                        let roleMapId = {};
                        data.data.forEach(({ idRole, label }) => {
                            roleMapId[label] = idRole;
                        });
                        roleId = roleMapId[newValue];
                        const myForm = new FormData();
                        myForm.append("route", "Compte")
                        myForm.append("id", idCompte);
                        myForm.append("action", "fk_role");
                        console.log("roleId : "+ roleId);
                        myForm.append("fk_role", roleId); // 1, 2 ou 3

                        const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                        }

                        myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                    }

                    
                    myFetch(null, callback, "api.php?route=Role&action=findall", "GET", errorCallback);
                }
            },

        ],
    });
};

export function clearTabulatorArea() {
    // On va vider la zone de login
    const container = document.getElementById('example-table');
    container.style.borderBottom = 'none'; // On enlève la bordure
    container.innerHTML = ''; // On vide la zone de login
}