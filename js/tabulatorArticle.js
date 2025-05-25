import { myFetch } from './fetch.js';

export const afficheTabulatorArticle = function(data) {

    let authorMap = {};
    let authorNameMap = {};
    
    const container = document.getElementById('example-table');
    container.style.borderBottom = '5px solid #222';

    fetch('api.php?route=Compte&action=findall')
    .then(response => {
      if (!response.ok) {
        throw new Error(`Erreur réseau (${response.status})`);
      }
      return response.json();
    })
    .then(json => {
      if (!Array.isArray(json.data)) {
        throw new Error('Format inattendu de la réponse compte');
      }
      json.data.forEach(({ idCompte, pseudo }) => {
        authorNameMap[pseudo] = idCompte;
      });
      authorNameMap;
      json.data.forEach(({ idCompte, pseudo }) => {
        authorMap[pseudo] = pseudo;
      });
      authorMap;
    });

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
            { title: "ID", field: "idArticle", headerFilter: "input" },

            { title: "Titre", field: "titre", editor: "input", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idArticle = cell.getRow().getData().idArticle;

                    const myForm = new FormData();
                    myForm.append("route", "Article")
                    myForm.append("id", idArticle);
                    myForm.append("action", key);
                    myForm.append(key, newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du tabulatorArticle - titre :", error);
                            cell.restoreOldValue();
                    }
                    
                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "Contenu", field: "contenu", editor: "input", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idArticle = cell.getRow().getData().idArticle;

                    const myForm = new FormData();
                    myForm.append("route", "Article")
                    myForm.append("id", idArticle);
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
                    const idArticle = cell.getRow().getData().idArticle;

                    console.log(typeof newValue + " : " + newValue);

                    const myForm = new FormData();
                    myForm.append("route", "Article")
                    myForm.append("id", idArticle);
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
                    const idArticle = cell.getRow().getData().idArticle;

                    const myForm = new FormData();
                    myForm.append("route", "Article")
                    myForm.append("id", idArticle);
                    myForm.append("action", key);
                    myForm.append(key, newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }

                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "estPublic", field: "estPublic", editor: true, formatter:"tickCross" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idArticle = cell.getRow().getData().idArticle;

                    const myForm = new FormData();
                    myForm.append("route", "Article")
                    myForm.append("id", idArticle);
                    myForm.append("action", key);
                    myForm.append(key, + newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }

                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "enAttenteDeModeration", field: "enAttenteDeModeration", editor: true, formatter:"tickCross" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idArticle = cell.getRow().getData().idArticle;

                    const myForm = new FormData();
                    myForm.append("route", "Article")
                    myForm.append("id", idArticle);
                    myForm.append("action", key);
                    myForm.append(key, + newValue);

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
                    const idArticle = cell.getRow().getData().idArticle;

                    const myForm = new FormData();
                    myForm.append("route", "Article")
                    myForm.append("id", idArticle);
                    myForm.append("action", key);
                    myForm.append(key, + newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }
                    
                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },
            { title: "Autheur", field: "auteur.pseudo", formatter: "plaintext", editor: "list", headerFilter: "input",
                editorParams: {
                    allowEmpty: false,
                    values: authorMap
                },
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const idArticle = cell.getRow().getData().idArticle;

                    let compteId;

                    const callback = function(data) {
                        let compteMapId = {};
                        data.data.forEach(({ idCompte, pseudo }) => {
                            compteMapId[pseudo] = idArticle;
                        });
                        compteId = compteMapId[newValue];
                        const myForm = new FormData();
                        myForm.append("route", "Article")
                        myForm.append("id", idArticle);
                        myForm.append("action", "fk_auteur");
                        console.log("compteId : "+ compteId);
                        myForm.append("fk_auteur", authorNameMap[newValue]); // 1, 2 ou 3

                        const errorCallback = function(error) {
                            alert("Erreur lors de la modification de l'auteur :", error);
                            cell.restoreOldValue();
                        }

                        myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                    }

                    const errorCallback = function(error) {
                        alert("Erreur lors de la modification de l'auteur :", error);
                        cell.restoreOldValue();
                    }
                    
                    myFetch(null, callback, "api.php?route=Compte&action=findall", "GET", errorCallback);
                }
            },

            { title: "Modere Par", field: "moderePar.pseudo", formatter: "plaintext", editor: "list", headerFilter: "input",
                editorParams: {
                    allowEmpty: false,
                    values: authorMap
                },
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const idArticle = cell.getRow().getData().idArticle;

                    let compteId;

                    const callback = function(data) {
                        let compteMapId = {};
                        data.data.forEach(({ idCompte, pseudo }) => {
                            compteMapId[pseudo] = idArticle;
                        });
                        compteId = compteMapId[newValue];
                        const myForm = new FormData();
                        myForm.append("route", "Article")
                        myForm.append("id", idArticle);
                        myForm.append("action", "fk_moderePar");
                        console.log("compteId : "+ compteId);
                        myForm.append("fk_moderePar", authorNameMap[newValue]); // 1, 2 ou 3

                        const errorCallback = function(error) {
                            alert("Erreur lors de la modification de l'auteur :", error);
                            cell.restoreOldValue();
                        }

                        myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                    }

                    const errorCallback = function(error) {
                        alert("Erreur lors de la modification de l'auteur :", error);
                        cell.restoreOldValue();
                    }
                    
                    myFetch(null, callback, "api.php?route=Compte&action=findall", "GET", errorCallback);
                }
            },

            { title: "Date moderation", field: "dateModeration", editor: "date", editorParams: {format: "yyyy-MM-dd hh:mm:ss"}, headerFilter: "date" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idArticle = cell.getRow().getData().idArticle;

                    const myForm = new FormData();
                    myForm.append("route", "Article")
                    myForm.append("id", idArticle);
                    myForm.append("action", key);
                    myForm.append(key, newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du rôle :", error);
                            cell.restoreOldValue();
                    }

                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

                }
            },

            { title: "Moderation Description", field: "moderationDescription", editor: "input", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    const key = cell.getField();
                    const idArticle = cell.getRow().getData().idArticle;

                    const myForm = new FormData();
                    myForm.append("route", "Article")
                    myForm.append("id", idArticle);
                    myForm.append("action", key);
                    myForm.append(key, newValue);

                    const errorCallback = function(error) {
                            alert("Erreur lors de la modification du tabulatorArticle - moderationDescription :", error);
                            cell.restoreOldValue();
                    }
                    
                    myFetch(myForm, function(data) {console.log("Modification réussie !")}, "api.php", "PUT", errorCallback);

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