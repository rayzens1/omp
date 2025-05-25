<?php

require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractController.php");
require_once(ROOT . "/services/ArticleService.php");
require_once(ROOT . "/model/Compte.php");
require_once(ROOT . "/exceptions/HttpStatusException.php");
require_once(ROOT . "/utils/functions.php");

class ArticlePutController extends AbstractController implements IController {

    protected ArticleService $service;

    
    public function __construct(array $form ){
        parent::__construct($form);
        $this->service = new ArticleService();
    }

    protected function checkForm() { 
        if ( !isset($this->form['action']) ) {
            throw new HttpStatusException(400, "param login not exists");
        }
        if ( !isset($this->form['id']) ) {
            throw new HttpStatusException(400, "param id not exists");
        }
        switch ($this->form['action']) {
            case 'titre':
                if ( !isset($this->form['titre']) ) {
                    throw new HttpStatusException(400, "param titre not exists");
                }
                break;
            case 'contenu':
                if ( !isset($this->form['contenu']) ) {
                    throw new HttpStatusException(400, "param password not exists");
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
            case 'estPublic':
                if ( !isset($this->form['estPublic']) ) {
                    throw new HttpStatusException(400, "param estPublic not exists");
                }
                break;
            case 'enAttenteDeModeration':
                if ( !isset($this->form['enAttenteDeModeration']) ) {
                    throw new HttpStatusException(400, "param enAttenteDeModeration not exists");
                }
                break;
            case 'estSupprime':
                if ( !isset($this->form['estSupprime']) ) {
                    throw new HttpStatusException(400, "param estSupprime not exists");
                }
                break;
            case 'fk_auteur':
                if ( !isset($this->form['fk_auteur']) ) {
                    throw new HttpStatusException(400, "param fk_auteur not exists");
                }
                $compteService = new CompteService();
                /** @var CompteService $compteService */
                $compte = $compteService->findById($this->form['fk_auteur']);
                if (is_null($compte)) {
                    throw new HttpStatusException(400, "param fk_auteur not valid");
                }
                break;
            default:
                throw new HttpStatusException(400, "ArticlePut param action not valid ". $this->form['action']);
        }
    }

	protected function checkCybersec() { 
        if (!isLogged()) {
            throw new HttpStatusException(401, "Not logged");
        }
    }

    protected function getRoleRequiredForAction(string $action) : int {
        switch ($action) {
            case 'fk_auteur':
                return 3; // Seul un admin peut changer le rôle d'un utilisateur
            case 'enAttenteDeModeration':
                return 3;
            case 'estSupprime':
                return 3;
            default:
                return 2;
        }
    }

    protected function checkRights() {
        // On récupère le rôle de l'utilisateur connecté
        // Ensuite in récupère le rôle requis pour l'action fournis dans le formulaire
        // Et on compare les deux
        if(!($_SESSION['roleId'] >= $this->getRoleRequiredForAction($this->form['action']))) {
            throw new HttpStatusException(403, "You don't have the right to change the role of a user !". $_SESSION['roleId'] . "!=". $this->getRoleRequiredForAction($this->form['action']));
        }
    }

	protected function processRequest() {

        error_log("DEBUG : ".$this->form['id']);
        error_log("DEBUG2 : ".$this->form['fk_auteur']);
        $article = $this->service->findById( $this->form['id'] );

        /** @var Article $article */

        switch ($this->form['action']) {
            case 'titre':
                if ( !isset($this->form['titre']) ) {
                    throw new HttpStatusException(400, "param titre not exists");
                }
                $article->setTitre($this->form['titre']);
                break;
            case 'contenu':
                if ( !isset($this->form['contenu']) ) {
                    throw new HttpStatusException(400, "param contenu not exists");
                }
                $article->setContenu($this->form["contenu"]);
                break;
            case 'dateCreation':
                if ( !isset($this->form['dateCreation']) ) {
                    throw new HttpStatusException(400, "param dateCreation not exists");
                }
                $article->setDateCreation($this->form['dateCreation']);
                break;
            case 'dateModification':
                if ( !isset($this->form['dateModification']) ) {
                    throw new HttpStatusException(400, "param dateModification not exists");
                }
                $article->setDateModification($this->form['dateModification']);
                break;
            case 'estPublic':
                if ( !isset($this->form['estPublic']) ) {
                    throw new HttpStatusException(400, "param estPublic not exists");
                }
                $article->setEstPublic($this->form['estPublic']);
                break;
            case 'enAttenteDeModeration':
                if ( !isset($this->form['enAttenteDeModeration']) ) {
                    throw new HttpStatusException(400, "param enAttenteDeModeration not exists");
                }
                $article->setEnAttenteDeModeration($this->form['enAttenteDeModeration']);
                break;
            case 'estSupprime':
                if ( !isset($this->form['estSupprime']) ) {
                    throw new HttpStatusException(400, "param estSupprime not exists");
                }
                $article->setEstSupprime($this->form['estSupprime']);
                break;
            case 'fk_auteur':
                if ( !isset($this->form['fk_auteur']) ) {
                    throw new HttpStatusException(400, "param fk_role not exists");
                }
                $compteService = new CompteService();
                $article->setAuteur($compteService->findById($this->form['fk_auteur']));
                break;
        }

        // On met à jour la date de modification
        $article->setDateModification(date("Y-m-d H:i:s"));

        // On met à jour le compte avec la nouvelle valeur
        $this->response = $this->service->update($article);

        $this->response = "";
    }

}

?>