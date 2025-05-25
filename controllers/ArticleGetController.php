<?php

require_once(ROOT .  "/utils/controller/IController.php");
require_once(ROOT .  "/utils/controller/AbstractGetController.php");
require_once(ROOT . "/services/ArticleService.php");

class ArticleGetController extends AbstractGetController implements IController {

    protected ArticleService $service;
    
    public function __construct(array $form ){
        parent::__construct($form);
        $this->service = new ArticleService();
    }

    
	protected function getService() : IService { 
        return $this->service;
    }
    
    public function getRoleRequired(): int {
        return 1;
    }
    
}

?>