<?php

    require_once( ROOT . "/utils/controller/IController.php");
    require_once( ROOT . "/utils/functions.php");
    require_once( ROOT . "/services/CompteService.php");

    class SessionGetController implements IController {

        public function __construct(array $form) {
           // parent::__construct($form);
        }

        public function execute(): string {
            $sessionState = new stdClass();
            $sessionState->startTime = $_SESSION[START_TIME];
            $sessionState->endTime = $_SESSION[START_TIME] + getMaxTime();
            $sessionState->isLogged = isLogged();
            if(isLogged()) {
                $sessionInfo = new stdClass();
                $service = new CompteService();
                $compteId = $_SESSION['compteId'];
                $compte = $service->findById($compteId);

                $_SESSION['login'] = $compte->getLogin();
                $_SESSION['pseudo'] = $compte->getPseudo();
                $_SESSION['role'] = $compte->getRole()->getLabel();

                $sessionInfo->login = $_SESSION['login'];
                $sessionInfo->pseudo = $_SESSION['pseudo'];
                $sessionInfo->role = $_SESSION['role'];
                
                $sessionState->userInfo = $sessionInfo;
            }
            return json_encode($sessionState);
        }

    }

?>