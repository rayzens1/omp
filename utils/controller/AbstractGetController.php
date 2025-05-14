<?php

require_once(ROOT .  "/utils/functions.php");
require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/exceptions/HttpStatusException.php");
require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractController.php");

abstract class AbstractGetController extends AbstractController implements IController {

    protected int $id;
    protected $response;
    
    public function __construct(array $form ){
        parent::__construct($form);
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

    protected abstract function getService() : IService;

	protected function processRequest() { 
        $this->response = $this->getService()->findById($this->id);
    }

}