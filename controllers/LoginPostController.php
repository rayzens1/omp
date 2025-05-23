<?php

require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractController.php");
require_once(ROOT . "/services/CompteService.php");
require_once(ROOT . "/model/Compte.php");
require_once(ROOT . "/exceptions/HttpStatusException.php");
require_once(ROOT . "/utils/functions.php");

class LoginPostController extends AbstractController implements IController {

    protected CompteService $service;
    private string $login;
    private string $password;
    
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
    }

	protected function checkCybersec() { 
        if(!isSanitizedString($this->form['login'])) {
            throw new HttpStatusException(400, "param login not a valid string");
        }
        $this->login = sanitizeString($this->form['login']);
        if(!isSanitizedString($this->form['password'])) {
            throw new HttpStatusException(400, "param login not a valid string");
        }
        $this->password = sanitizeString($this->form['password']);
    }

	protected function processRequest() {
        if (isLogged()) {
            throw new HttpStatusException(499, "Already logged");
        }
        $compte = Compte::createForCredential($this->login, $this->password);
        $id = $this->service->isValidCredential($compte);
        if ( is_null($id) ) { // Si id == null, c'est que le login ou le mot de passe est incorrect
            throw new HttpStatusException(499, "Invalid Credential");
        }
        login($id);
        $this->response = "";
    }

}

?>