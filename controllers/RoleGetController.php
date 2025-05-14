<?php

require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractController.php");
require_once(ROOT . "/services/RoleService.php");

class RoleGetController extends AbstractController implements IController {

    protected RoleService $service;
    
    public function __construct(array $form ){
        parent::__construct($form);
        $this->service = new RoleService();
    }

    public function getService() : IService {
        return $this->service;
    }

}