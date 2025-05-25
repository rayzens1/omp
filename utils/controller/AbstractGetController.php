<?php

require_once(ROOT .  "/utils/functions.php");
require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/exceptions/HttpStatusException.php");
require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractController.php");

abstract class AbstractGetController extends AbstractController implements IController {

    protected int $id;
    protected string $action;
    protected $response;
    
    public function __construct(array $form ){
        parent::__construct($form);
    }

	protected function checkForm() { 

        // On vérifie que la param action est définie
        if(!isset($this->form['action'])) {
            throw new HttpStatusException(400, "param action not exists");
        }
        // On vérifie que la param action est une chaîne de caractères pour l'utiliser pour connaitre quels champs sont à récupérer
        $this->action = sanitizeString(strtolower($this->form['action']));

        // On vérifie que les params en fonction de l'action sont bien présents
        switch ($this->action) {
            case 'findbyid':
                if ( !isset($this->form['id']) ) {
                    throw new HttpStatusException(400, "param id not exists");
                }
                break;
            case 'findall':
                // Pas de paramètre à vérifier
                break;
            default:
                throw new HttpStatusException(400, "param action not valid");
        }
     }

	protected function checkCybersec() {
        if($this->action == 'findbyid' && !isNaturalNumber($this->form['id'])) {
            throw new HttpStatusException(400, "param id not a valid number");
        }
        $this->id = (int)$this->form['id'];
    }

    protected function checkRights() {
        
        if(!($_SESSION['roleId'] >= $this->getRoleRequired())) {
            throw new HttpStatusException(403, "You don't have the right to access this resource !" );
        }
    }

    protected abstract function getRoleRequired() : int;

    protected abstract function getService() : IService;

	protected function processRequest() {
        switch ($this->action) {
            case 'findbyid':
                $this->response = $this->getService()->findById($this->id);
                break;
            case 'findall':
                $this->response = $this->getService()->findAll();
                break;
        }
    }

}