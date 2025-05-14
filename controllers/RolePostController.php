<?php

require_once(ROOT .  "/utils/functions.php");
require_once(ROOT .  "/exceptions/HttpStatusException.php");
require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT . "/services/RoleService.php");
require_once(ROOT . "/model/Role.php");

class RolePostController implements IController {

    protected array $form;
    protected string $label;
    protected RoleService $service;
    protected $response;
    
    public function __construct(array $form ){
        $this->form = $form;
        $this->service = new RoleService();
    }

	function execute() : string {
		$this->checkForm();		// Vérifier les données de formulaires
		$this->checkCybersec();		// Vérifier la cybersécurité
		$this->checkRights();		// Controller les droits d'accès
		$this->processRequest();	// traiter la requete
        return $this->processResponse();	// Retourner la réponse
	}

	protected function checkForm() { 
        if ( !isset($this->form['label']) ) {
            throw new HttpStatusException(400, "param label not exists");
        }
     }

	protected function checkCybersec() { 
        if(preg_match("/[^a-zA-Z0-9]/", $this->form['label']) > 0) {
            throw new HttpStatusException(400, "param label contain special char");
        }
        $this->label = $this->form['label'];
    }

	protected function checkRights() { error_log( __LINE__ . " ". __FUNCTION__); }

	protected function processRequest() {
        $role = new Role();
        $role->setLabel($this->label);
        $this->response = $this->service->insert($role);
    }

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