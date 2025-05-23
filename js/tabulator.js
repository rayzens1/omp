export const afficheTabulator = function(data) {

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
        paginationSize: 7,
        paginationCounter: "rows",
        movableColumns: true,

        // 1) On désactive l’auto-génération
        autoColumns: false,

        // 2) On déclare manuellement les colonnes et on active l’éditeur
        columns: [
            { title: "ID", field: "idCompte", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            },

            { title: "Login", field: "login", editor: "input", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            },

            { title: "Mot de passe", field: "password", editor: "input", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            },

            { title: "Pseudo", field: "pseudo", editor: "input", headerFilter: "input" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            },

            { title: "Date création", field: "dateCreation", editor: "date", editorParams: {format: "yyyy-MM-dd hh:mm:ss"}, headerFilter: "date" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            },

            { title: "Date modif.", field: "dateModification", editor: "date", editorParams: {format: "yyyy-MM-dd hh:mm:ss"}, headerFilter: "date" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            },

            { title: "estSupprime", field: "estSupprime", editor: true, formatter:"tickCross" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            },

            { title: "estSignale", field: "estSignale", editor: true, formatter:"tickCross" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            },

            { title: "estBanni", field: "estBanni", editor: true, formatter:"tickCross" ,
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            },

            { title: "enAttenteDeModeration", field: "enAttenteDeModeration", editor: true, formatter:"tickCross",
                cellEdited: cell => {
                    const newValue = cell.getValue();
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                }
            }, // headerFilter: "tickCross"

            { title: "Rôle", field: "role.label", formatter: "plaintext", editor: "list", headerFilter: "input",
                editorParams: {
                    allowEmpty: false,
                    values: roleMap
                },
                cellEdited: cell => {
                    const newId = cell.getValue();
                    // cell.getRow().getData().role.label = roleMap[newId];
                    console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
                },
            },

        ],

        // 3) Optionnel : callback après édition
        // cellEdited: function(cell) {
        //     const field    = cell.getField();
        //     const value    = cell.getValue();
        //     const rowData  = cell.getRow().getData();

        //     console.log("Cell edited:", cell.getField(), "=>", cell.getValue());
        //     // Ici, faites un fetch/axios pour persister la modif en base, ex :
        //     // fetch("/api/comptes/" + cell.getRow().getData().idCompte, {method:"PATCH", body:JSON.stringify({[cell.getField()]:cell.getValue()})})
        // },


    });

    const printConsole = function() {
        console.log("Print Console");
    }
};

export function clearTabulatorArea() {
    // On va vider la zone de login
    const container = document.getElementById('example-table');
    container.style.borderBottom = 'none'; // On enlève la bordure
    container.innerHTML = ''; // On vide la zone de login
}