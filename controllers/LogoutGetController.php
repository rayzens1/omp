<?php

require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractController.php");
require_once(ROOT . "/services/CompteService.php");
require_once(ROOT . "/utils/functions.php");

class LogoutGetController extends AbstractController implements IController {
    
    public function __construct(array $form ){
        parent::__construct($form);
    }

    protected function checkForm() { 
        // RAS
    }

    protected function checkCybersec() { 
        // RAS
    }

    protected function processRequest() {
        reinitSession();
        $this->response = "";
    }

    protected function getService() : IService {
        throw new Exception("Ce controlleur n'a pas besoin de service");
    }

}

?>