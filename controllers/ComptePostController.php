<?php

require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractController.php");
require_once(ROOT . "/services/CompteService.php");
require_once(ROOT . "/model/Compte.php");
require_once(ROOT . "/exceptions/HttpStatusException.php");
require_once(ROOT . "/utils/functions.php");

class ComptePostController extends AbstractController implements IController {

    protected CompteService $service;
    private string $login;
    private string $password;
    private string $passwordc;
    private string $pseudo;
    
    public function __construct(array $form ){
        parent::__construct($form);
        $this->service = new CompteService();
    }

    protected function checkForm() { 
        if ( !isset($this->form['login']) ) {
            throw new HttpStatusException(400, "param login not exists");
        }
        if ( !isset($this->form['password']) ) {
            throw new HttpStatusException(400, "param password not exists");
        }
        if ( !isset($this->form['passwordc']) ) {
            throw new HttpStatusException(400, "param passwordc not exists");
        }
        if ( !isset($this->form['pseudo']) ) {
            throw new HttpStatusException(400, "param pseudo not exists");
        }
    }

	protected function checkCybersec() { 
        if(!isSanitizedString($this->form['login'])) {
            throw new HttpStatusException(400, "param login not a valid string");
        }
        $this->login = sanitizeString($this->form['login']);
        if(!isSanitizedString($this->form['password'])) {
            throw new HttpStatusException(400, "param password not a valid string");
        }
        $this->password = sanitizeString($this->form['password']);
        if(!isSanitizedString($this->form['passwordc'])) {
            throw new HttpStatusException(400, "param passwordc not a valid string");
        }
        $this->passwordc = sanitizeString($this->form['passwordc']);
        if(!isSanitizedString($this->form['pseudo'])) {
            throw new HttpStatusException(400, "param pseudo not a valid string");
        }
        $this->pseudo = sanitizeString($this->form['pseudo']);
    }

	protected function processRequest() {
        if (isLogged()) {
            throw new HttpStatusException(499, "Already logged");
        }
        if($this->password != $this->passwordc) {
            throw new HttpStatusException(400, "Password not same");
        }

        $compte = Compte::createFromForm($this->form);

        $this->response = $this->service->insert($compte);
    }

}

?>