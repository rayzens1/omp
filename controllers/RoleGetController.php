<?php

require_once(ROOT .  "/utils/functions.php");
require_once(ROOT .  "/exceptions/HttpStatusException.php");
require_once(ROOT .  "/utils/IController.php");

class RoleGetController implements IController {

    protected array $form;
    protected int $id;
    
    public function __construct(array $form ){
        $this->form = $form;
    }

	function execute() {
		$this->checkForm();		// Vérifier les données de formulaires
		$this->checkCybersec();		// Vérifier la cybersécurité
		$this->checkRights();		// Controller les droits d'accès
		$this->processRequest();	// traiter la requete
		$this->processResponse();	// fournir la réponse
	}

	protected function checkForm() { 
        if ( !isset($this->form['id']) ) {
            throw new HttpStatusException(400, "param id not exists");
        }
     }

	protected function checkCybersec() { 
        if(!isNaturalNumber($this->form['id'])) {
            throw new HttpStatusException(400, "param id not a number");
        }
        $this->id = intVal($this->form['id']);
    }

	protected function checkRights() {error_log( __LINE__ . " ". __FUNCTION__); }
	protected function processRequest() {error_log( __LINE__ . " ". __FUNCTION__); }
    protected function processResponse() {error_log( __LINE__ . " ". __FUNCTION__); }

}