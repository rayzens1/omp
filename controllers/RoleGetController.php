<?php

require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractGetController.php");
require_once(ROOT . "/services/RoleService.php");

class RoleGetController extends AbstractGetController implements IController {

    protected RoleService $service;
    
    public function __construct(array $form ){
        parent::__construct($form);
        $this->service = new RoleService();
    }

    public function getService() : IService {
        return $this->service;
    }

    public function getRoleRequired(): int {
        return 2; // ROLE_ADMIN
    }

}