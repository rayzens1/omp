<?php

require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractController.php");
require_once(ROOT . "/services/CompteService.php");
require_once(ROOT . "/model/Compte.php");
require_once(ROOT . "/exceptions/HttpStatusException.php");
require_once(ROOT . "/utils/functions.php");

class ComptePutController extends AbstractController implements IController {

    protected CompteService $service;

    
    public function __construct(array $form ){
        parent::__construct($form);
        $this->service = new CompteService();
    }

    protected function checkForm() { 
        if ( !isset($this->form['action']) ) {
            throw new HttpStatusException(400, "param login not exists");
        }
        if ( !isset($this->form['id']) ) {
            throw new HttpStatusException(400, "param id not exists");
        }
        switch ($this->form['action']) {
            case 'login':
                if ( !isset($this->form['login']) ) {
                    throw new HttpStatusException(400, "param login not exists");
                }
                break;
            case 'password':
                if ( !isset($this->form['password']) ) {
                    throw new HttpStatusException(400, "param password not exists");
                }
                break;
            case 'pseudo':
                if ( !isset($this->form['pseudo']) ) {
                    throw new HttpStatusException(400, "param pseudo not exists");
                }
                break;
            case 'dateCreation':
                if ( !isset($this->form['dateCreation']) ) {
                    throw new HttpStatusException(400, "param dateCreation not exists");
                }
                break;
            case 'dateModification':
                if ( !isset($this->form['dateModification']) ) {
                    throw new HttpStatusException(400, "param dateModification not exists");
                }
                break;
            case 'estSupprime':
                if ( !isset($this->form['estSupprime']) ) {
                    throw new HttpStatusException(400, "param estSupprime not exists");
                }
                break;
            case 'estSignale':
                if ( !isset($this->form['estSignale']) ) {
                    throw new HttpStatusException(400, "param estSignale not exists");
                }
                break;
            case 'estBanni':
                if ( !isset($this->form['estBanni']) ) {
                    throw new HttpStatusException(400, "param estBanni not exists");
                }
                break;
            case 'enAttenteDeModeration':
                if ( !isset($this->form['enAttenteDeModeration']) ) {
                    throw new HttpStatusException(400, "param enAttenteDeModeration not exists");
                }
                break;
            case 'fk_role':
                if ( !isset($this->form['fk_role']) ) {
                    throw new HttpStatusException(400, "param fk_role not exists");
                }
                $roleService = new RoleService();
                $role = $roleService->getRole($this->form['fk_role']);
                if (is_null($role)) {
                    throw new HttpStatusException(400, "param fk_role not valid");
                }
                break;
            default:
                throw new HttpStatusException(400, "param action not valid");
        }
    }

	protected function checkCybersec() { 
        if (!isLogged()) {
            throw new HttpStatusException(401, "Not logged");
        }
    }

    protected function getRoleRequiredForAction(string $action) : int {
        switch ($action) {
            case 'fk_role':
                return 3; // Seul un admin peut changer le rôle d'un utilisateur
            default:
                return 3;
        }
    }

    protected function checkRights() {
        // On récupère le rôle de l'utilisateur connecté
        // Ensuite in récupère le rôle requis pour l'action fournis dans le formulaire
        // Et on compare les deux
        if($_SESSION['roleId'] != $this->getRoleRequiredForAction($this->form['action'])) {
            throw new HttpStatusException(403, "You don't have the right to change the role of a user !");
        }
    }

	protected function processRequest() {

        $compte = $this->service->findById( $this->form['id'] );

        /** @var Compte $compte */

        switch ($this->form['action']) {
            case 'login':
                if ( !isset($this->form['login']) ) {
                    throw new HttpStatusException(400, "param login not exists");
                }
                $compte->setLogin($this->form['login']);
                break;
            case 'password':
                if ( !isset($this->form['password']) ) {
                    throw new HttpStatusException(400, "param password not exists");
                }
                $compte->setPassword($this->form["password"]);
                break;
            case 'pseudo':
                if ( !isset($this->form['pseudo']) ) {
                    throw new HttpStatusException(400, "param pseudo not exists");
                }
                $compte->setPseudo($this->form['pseudo']);
                break;
            case 'dateCreation':
                if ( !isset($this->form['dateCreation']) ) {
                    throw new HttpStatusException(400, "param dateCreation not exists");
                }
                $compte->setDateCreation($this->form['dateCreation']);
                break;
            case 'dateModification':
                if ( !isset($this->form['dateModification']) ) {
                    throw new HttpStatusException(400, "param dateModification not exists");
                }
                $compte->setDateModification($this->form['dateModification']);
                break;
            case 'estSupprime':
                if ( !isset($this->form['estSupprime']) ) {
                    throw new HttpStatusException(400, "param estSupprime not exists");
                }
                $compte->setEstSupprime($this->form['estSupprime']);
                break;
            case 'estSignale':
                if ( !isset($this->form['estSignale']) ) {
                    throw new HttpStatusException(400, "param estSignale not exists");
                }
                $compte->setEstSignale($this->form['estSignale']);
                break;
            case 'estBanni':
                if ( !isset($this->form['estBanni']) ) {
                    throw new HttpStatusException(400, "param estBanni not exists");
                }
                $compte->setEstBanni($this->form['estBanni']);
                break;
            case 'enAttenteDeModeration':
                if ( !isset($this->form['enAttenteDeModeration']) ) {
                    throw new HttpStatusException(400, "param enAttenteDeModeration not exists");
                }
                $compte->setEnAttenteDeModeration($this->form['enAttenteDeModeration']);
                break;
            case 'fk_role':
                if ( !isset($this->form['fk_role']) ) {
                    throw new HttpStatusException(400, "param fk_role not exists");
                }
                $roleService = new RoleService();
                $compte->setRole($roleService->findById($this->form['fk_role']));
                break;
        }

        // On met à jour la date de modification
        $compte->setDateModification(date("Y-m-d H:i:s"));

        // On met à jour le compte avec la nouvelle valeur
        $this->response = $this->service->update($compte);

        $this->response = "";
    }

}

?>