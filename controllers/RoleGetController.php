<?php

	require_once(ROOT . "/utils/IController.php");
	require_once(ROOT . "/utils/AbstractController.php");
	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/services/RoleService.php");

	class RoleGetController extends AbstractController implements IController {

		private RoleService $service;
		private int $id;

		public function __construct($form, $controllerName) {
			// Appel du constructeur de la classe mère AbstractController
			parent::__construct($form, $controllerName);
			$this->service = new RoleService();
		}

		function checkForm() {
			if (! isset($this->form['id']) ) { // l'id doit etre présent
				error_log("CYBERSEC Receive bad request");
				_400_Bad_Request();
			}
			// OK
		}

                function checkCybersec() {
			if ( ! ctype_digit( $this->form['id'] ) ) {
				error_log("CYBERSEC Receive bad request");
				_400_Bad_Request();
			}
			$this->id = intval( $this->form['id'] );
		}

                function checkRights() {
			error_log($this->controllerName . "->" . __FUNCTION__ . 
				"TODO - la fonction isLogged est bouchonnée, terminer le job");
			// TODO décommenter pour rendre ça opérationnel
//			if ( ! isLogged() ) {
//				_401_Unauthorized();
//			}
			// TODO Est ce que j'ai besoin de controller les droits rédacteur / Modo / Admin
		}

                function processRequest() {
			$this->response = $this->service->findById($this->id);
		}

	}

?>