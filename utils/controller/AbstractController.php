<?php

require_once(ROOT .  "/utils/functions.php");
require_once(ROOT .  "/exceptions/HttpStatusException.php");
require_once(ROOT .  "/utils/controller/IController.php");

abstract class AbstractController implements IController {

    protected array $form;
    protected $response;
    
    public function __construct(array $form ){
        $this->form = $form;
    }

	function execute() : string {
		$this->checkForm();		// Vérifier les données de formulaires
		$this->checkCybersec();		// Vérifier la cybersécurité
		$this->checkRights();		// Controller les droits d'accès
		$this->processRequest();	// traiter la requete
        return $this->processResponse();	// Retourner la réponse
	}

	protected abstract function checkForm();

	protected abstract function checkCybersec();

	protected function checkRights() {}

	protected abstract function processRequest();

    protected function processResponse() { 
        if ( $this->response == null ) {
            error_log("Unable to find something"); // TODO Faire une méthode abstraite
            throw new HttpStatusException(404, "Role not found");
        }
        $output = json_encode($this->response);
        $cleanOutput = ltrim($output); // Suppression des espaces et cie avant et après
        return $cleanOutput;
    }

}